function filter(){
  let fluxAll = document.body.getElementsByClassName("fluxAll")[0];
  let fluxFilter = document.body.getElementsByClassName("fluxFilter")[0];
  fluxAll.classList.toggle("active");
  fluxFilter.classList.toggle("active");
}