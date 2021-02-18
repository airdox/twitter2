function filter(){
  let tweets = document.body.getElementsByClassName("flux")[0].getElementsByTagName("li");
  console.log(tweets)
  for (let i=0, max=tweets.length; i < max; i++) {
    console.log(tweets[i].innerHTML);
  };
}