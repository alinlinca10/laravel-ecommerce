$("#dark-mode").change(function(){
  if($(this).prop("checked") == true){
    $("#html").attr("data-bs-theme", "dark");
    Cookies.set('theme', 'dark');
    $('.change-icon').removeClass('bi bi-moon-stars-fill');
    $('.change-icon').addClass('bi bi-sun');
  }else{
    $("#html").attr("data-bs-theme", "light");
    Cookies.set('theme', 'light');
    $('.change-icon').removeClass('bi bi-sun');
    $('.change-icon').addClass('bi bi-moon-stars-fill');
  }
});
