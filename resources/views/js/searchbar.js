// Delay Button display for effect
document.addEventListener("DOMContentLoaded", function() {
  let box = document.getElementById("scale");
  setTimeout(function() {
    box.classList.add("scale-in");
  }, 500);
});

/* hide when expanded*/
document.querySelector(".search-field").addEventListener("focus", function() {
  let hidden = document.querySelectorAll(".search-hide");

  for (let i = 0; i < hidden.length; ++i) {
    hidden[i].style.display = "none";
  }
});

/* show when expanded*/
document
  .querySelector(".search-field")
  .addEventListener("focusout", function() {
    let hidden = document.querySelectorAll(".search-hide");
    for (let i = 0; i < hidden.length; ++i) {
      hidden[i].style.display = "block";
    }
  });




// Event listener for keypress in search box/open
document.getElementById('search-input').addEventListener('keyup', searchEngine);
document.getElementById('search-input').addEventListener('focus', searchEngine);

  
  // Local Search Engine *Basic
function searchEngine(e){
  
  let input = document.getElementById('search-input');
  let html = '';
  let matchingResults = [];
  let heading = document.querySelector('.search-heading');
  
//   Find Matching Results
  if(input.value === ''){
    
    searchResults.forEach(function(obj){
      heading.textContent = 'Most Visited';
      
      if(obj.frequent === true){
        matchingResults.push(obj);
      }
    })
  } else {
    
    heading.textContent = 'Search Results';
    searchResults.forEach(function(obj){
      if(obj.title.toUpperCase().includes(input.value.toUpperCase())){
        matchingResults.push(obj);
      }
    })
  }
  


  if(matchingResults.length > 0){

    matchingResults.forEach(function(el){
      html += `<li><a class="grey-text" href="${el.link}">${boldString(el.title, input.value)}</a></li>`
    })
    document.querySelector('.popup-list').innerHTML = html;
  } else{
    html = `<li>There are no suggestions for your query.</li>`
    document.querySelector('.popup-list').innerHTML = html;
  }

}




// Stored search results
let searchResults = [
  {
    title: 'CodePen',
    description: 'This is just a test',
    link: '#test1',
    frequent: false
  },
  {
    title: 'Facebook',
    description: 'Something else to test',
    link: '#test2',
    frequent: false
  },
  {
    title: 'Font Awesome',
    description: 'Something else to test',
    link: '#test3',
    frequent: false
  },
  {
    title: 'Link 1',
    description: 'Something else to test, just a link name.',
    link: '#test4',
    frequent: false
  },
  {
    title: 'Stack Overflow',
    description: 'Something else to test, just another link name.',
    link: '#test5',
    frequent: false
  },
  {
    title: 'Google',
    description: 'Something else to test, just another link name.',
    link: '#googletest',
    frequent: true
  },
  {
    title: 'Apple',
    description: 'Something else to test, just another link name.',
    link: '#appletest',
    frequent: true
  },
  {
    title: 'Microsoft',
    description: 'Something else to test, just another link name.',
    link: '#Microsofttest',
    frequent: true
  },
  {
    title: 'Github',
    description: 'Something else to test, just another link name.',
    link: '#githubtest',
    frequent: true
  }
]

// Help bold matching results
function boldString(str, find){
  var re = new RegExp(find, 'i');
  find = re.exec(str);
  return str.replace(re, '<b>'+find+'</b>');
}