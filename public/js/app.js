var toggle = false;
function filter(){
  toggle = !toggle;

  let tweets = document.body.getElementsByClassName("flux")[0].getElementsByTagName("li");
  
  for (let i=0, max=tweets.length; i < max; i++) {
    if(!tweets[i].classList.contains('retweet')) {
      if(toggle === true) {
        tweets[i].style.display = 'none';
      } else {
        tweets[i].style.display = 'block';
      }
    }
  };
}