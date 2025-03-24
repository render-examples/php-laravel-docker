require('./bootstrap');

import $ from 'jquery'
import 'slick-carousel';

$(function() {
    let slideCount = $('.slick-slider div').length;

    $('.slick-slider').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        dots: slideCount > 1,
        arrows: true,
        infinite: slideCount > 1,
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    // ラジオボタンが変更されたときのイベントリスナー
    $('.stars input[type="radio"]').on('change', function() {
        
        // 選択されたラジオボタンの値をコンソールに表示
        console.log("選択された評価: " + $(this).val());

        let rating = $(this).val();
        let postId = $('.stars input[type="hidden"]').val();

        $.ajax({
            url: "/ajax/eval",
            method: "POST",
            data: {rating : rating, postId : postId},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            } 
        }).done(function(res) {
            console.log('登録 or 更新に成功しました');
            console.log(res);
        }).fail(function() {
            alert('通信を失敗しました');
        });
    });
});
