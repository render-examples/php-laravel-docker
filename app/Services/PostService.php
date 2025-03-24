<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class PostService
{
    private $maxPage; // 最大ページ数
    private $nowPage; // 現在のページ番号

    /**
     * ページャー情報をセットする
     */
    public function setPagerInfo($pageId) {
        $this->nowPage = $pageId;
    }

    /**
     * ページャーの情報を返す
     */
    public function getPagerInfo() {
        return ['maxPage' => $this->maxPage, 'nowPage' => $this->nowPage];
    }

    /**
     * 店舗一覧情報をView用に変換する
     * @return array
     */
    public function convShopData(): array
    {
        // 店舗情報を取得する
        $shopInfo = $this->getShopInfo();
        
        // タグを全種類取得する
        $tags = $this->getAllTags();

        // View用にタグを変換
        foreach ($shopInfo as &$si) {
            $si['tags'] = $this->convTagsData($si['tags'], $tags);
        }

        unset($si);

        return $shopInfo;
    }

    /**
     * 店舗詳細の情報をView用に変換する
     * @param int $shopId
     * @return array
     */
    public function convShopDetailData(int $shopId): array
    {
        // 店舗詳細情報を取得する
        $shopDetail = $this->getShopDetail($shopId);
        
        // タグを全種類取得する
        $tags = $this->getAllTags();

        // View用にタグを変換
        $shopDetail['tags'] = $this->convTagsData($shopDetail['tags'], $tags);

        return $shopDetail;
    }

    /**
     * タグデータをView用に変換する関数（例：「1,2,3」→「[1=>中華, 2=>フレンチ, 3=>寿司]」）
     * @param string $shopTags
     * @param array $tags
     * @return array
     */
    public function convTagsData(string $shopTags, array $tags): array
    {
        // タグリストの初期化
        $tagList = [];

        $tagIds = explode(',', $shopTags);

        // 店舗に付けられているタグをリストに追加
        foreach ($tagIds as $tagId) {
            if (isset($tags[$tagId])) {
                $tagList[] = $tags[$tagId];
            }
        }
        
        return $tagList;
    }

    /**
     * 店舗情報をDBから取得する
     * @return array
     */
    public function getShopInfo(): array
    {
        $sql  = 'SELECT posts.id, posts.shopname, posts.tags, deleted_flg,'.PHP_EOL;
        $sql .= 'ROUND(AVG(rating)::numeric, 1) AS avg_rating, MAX(image_url) AS image_url'.PHP_EOL;
        $sql .= 'FROM posts'.PHP_EOL;
        $sql .= '   LEFT JOIN ratings'.PHP_EOL;
        $sql .= '       ON posts.id = ratings.post_id'.PHP_EOL;
        $sql .= '   LEFT JOIN images'.PHP_EOL;
        $sql .= '       ON posts.id = images.post_id'.PHP_EOL;
        $sql .= 'WHERE deleted_flg != true'.PHP_EOL;
        $sql .= 'GROUP BY posts.id, posts.shopname, posts.tags, posts.deleted_flg'.PHP_EOL;
        $sql .= 'ORDER BY avg_rating DESC'.PHP_EOL;

        $result    = DB::select($sql);
        $convArray = array_map(fn($row) => (array) $row, $result); // 配列内のオブジェクトを配列に変換

        return $this->pager($convArray);
    }

    /**
     * タグを全て取得する
     * @return array
     */
    public function getAllTags(): array
    {
        $sql  = 'SELECT id, name'.PHP_EOL;
        $sql .= 'FROM tags'.PHP_EOL;

        $result = DB::select($sql);
        $convArray = array_map(fn($row) => (array) $row, $result); // 配列内のオブジェクトを配列に変換
        $dispTags = array_column($convArray, null, 'id'); // 配列のキーをタグのidに変換

        return $dispTags;
    }

    /**
     * ユーザーがお気に入り（いいね）した投稿の post_id を取得する
     * @param int $user_id
     * @return array ユーザーが良いねした投稿のidリスト
     */
    public function getFavorites(int $user_id): array
    {
        $sql  = 'SELECT Favorites.post_id'.PHP_EOL;
        $sql .= '   FROM Favorites'.PHP_EOL;
        $sql .= 'WHERE user_id = :user_id'.PHP_EOL;

        return DB::select($sql, ['user_id' => $user_id]);
    }

    /**
     * 投稿一覧ページのページャー
     * @param array $shopData
     * @return array 表示用データ
     */
    private function pager(array $shopData): array
    {
        $max = 10; // 1ページの最大表示件数

        $shopNum = count($shopData); // 現在の合計店舗数

        $this->maxPage = ceil($shopNum / $max); // 最大ページ数
        
        if (!isset($this->nowPage)) {
            $this->nowPage = 1; // 特に指定されていなければ1ページ目を取得する
        }

        $startNo = ($this->nowPage - 1) * $max; // 開始ページ番号を取得する

        $dispData = array_slice($shopData, $startNo, $max, true);

        return $dispData;
    }

    /**
     * 店舗詳細を取得
     * @param $shopId 店舗id
     * @return array 店舗情報
     */
    public function getShopDetail(int $shopId): array
    {
        $sql  = 'SELECT posts.id, posts.shopname, posts.tags,'.PHP_EOL;
        $sql .= 'ROUND(AVG(rating)::numeric, 1) AS avg_rating, post_details.address'.PHP_EOL;
        $sql .= 'FROM posts'.PHP_EOL;
        $sql .= '   LEFT JOIN ratings'.PHP_EOL;
        $sql .= '       ON posts.id = ratings.post_id'.PHP_EOL;
        $sql .= '   INNER JOIN post_details'.PHP_EOL;
        $sql .= '       ON posts.id = post_details.post_id'.PHP_EOL;
        $sql .=     'WHERE posts.id = :shopId'.PHP_EOL;
        $sql .= 'GROUP BY posts.id, posts.shopname, posts.tags, posts.deleted_flg, post_details.address'.PHP_EOL;
        $sql .= 'ORDER BY avg_rating DESC'.PHP_EOL;

        $result = DB::select($sql, ['shopId' => $shopId]);

        return !empty($result) ? (array) current($result) : [];
    }

    /**
     * 店舗の画像を取得
     * @param int $shopId
     * @return array
     */
    public function getShopImages(int $shopId): array
    {
        $sql  = 'SELECT images.image_url'.PHP_EOL;
        $sql .= 'FROM posts'.PHP_EOL;
        $sql .= '    LEFT JOIN images'.PHP_EOL;
        $sql .= '    ON posts.id = images.post_id'.PHP_EOL;
        $sql .= '   WHERE posts.id = :shopId'.PHP_EOL;

        $param = [
            'shopId' => $shopId
        ];

        $result = DB::select($sql, $param);
        $convArray = array_map(fn($row) => (array) $row, $result); // 配列内のオブジェクトを配列に変換

        return $convArray;
    }

    public function getRating(int $userId, int $postId)
    {
        $sql  = 'SELECT * FROM ratings'.PHP_EOL;
	    $sql .= 'WHERE user_id = :userId AND post_id = :postId'.PHP_EOL;

        $params = [
            'userId' => $userId,
            'postId' => $postId,
        ];

        $result = DB::select($sql, $params);

        return !empty($result) ? (array) current($result) : [];
    }

    public function storeReview(int $userId, int $postId, int $rating)
    {
        $sql  = 'INSERT INTO ratings'.PHP_EOL;
        $sql .= '(user_id, post_id, rating, created_at, updated_at)'.PHP_EOL;
        $sql .= 'VALUES (:userId, :postId, :rating, NOW(), NOW())'.PHP_EOL;

        $params = [
            'userId' => $userId,
            'postId' => $postId,
            'rating' => $rating
        ];

        DB::insert($sql, $params);
    }

    public function updateReview(int $userId, int $postId, int $rating)
    {
        $sql  = 'UPDATE ratings SET rating = :rating'.PHP_EOL;
        $sql .= 'WHERE user_id = :userId AND post_id = :postId'.PHP_EOL;

        $params = [
            'userId' => $userId,
            'postId' => $postId,
            'rating' => $rating        
        ];

        DB::update($sql, $params);
    }

    public function insertPosts(string $shopName, string $tags)
    {
        $sql  = 'INSERT INTO posts'.PHP_EOL;
        $sql .= '(shopname, tags, deleted_flg, created_at, updated_at)'.PHP_EOL;
        $sql .= 'VALUES (:shopname, :tags, :deleted_flg, NOW(), NOW())'.PHP_EOL;

        $params = [
            'shopname'    => $shopName,
            'tags'        => $tags,
            'deleted_flg' => false,
        ];

        DB::insert($sql, $params);
    }

    public function insertPostDetail(string $address, int $postId)
    {
        $sql  = 'INSERT INTO post_details'.PHP_EOL;
        $sql .= '(address, post_id, created_at, updated_at)'.PHP_EOL;
        $sql .= 'VALUES (:address, :postId, NOW(), NOW())'.PHP_EOL;

        $params = [
            'address'     => $address,
            'postId'     => $postId,
        ];

        DB::insert($sql, $params);
    }

    public function getShopByMaxId()
    {
        $sql  = 'SELECT MAX(id) AS shopId FROM posts'.PHP_EOL;
        $result = DB::select($sql);

        return !empty($result) ? (array) current($result) : [];
    }

    public function updatePosts(string $shopName, string $tags, int $postId)
    {
        $sql  = 'UPDATE posts SET shopname = :shopname, tags = :tags, updated_at = NOW()'.PHP_EOL;
        $sql .= 'WHERE posts.id = :postId'.PHP_EOL;

        $params = [
            'shopname'    => $shopName,
            'tags'        => $tags,
            'postId'      => $postId,
        ];

        DB::update($sql, $params);
    }

    public function updatePostDetail(string $address, int $postId)
    {
        $sql  = 'UPDATE post_details SET address = :address, updated_at = NOW()'.PHP_EOL;
        $sql .= 'WHERE post_id = :postId'.PHP_EOL;

        $params = [
            'address'     => $address,
            'postId'      => $postId,
        ];

        DB::update($sql, $params);
    }

    public function softDelete(int $id)
    {
        $sql  = 'UPDATE posts SET deleted_flg = :deleted_flg, , updated_at = NOW()'.PHP_EOL;
        $sql .= 'WHERE posts.id = :postId'.PHP_EOL;

        $params = [
            'deleted_flg' => true,
            'postId'      => $id,
        ];

        DB::update($sql, $params);
    }
}
