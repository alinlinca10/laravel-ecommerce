$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$(document).ready(function () {
    $("#dark-mode").change(function () {
        if ($(this).prop("checked") == true) {
          $("#html").attr("data-bs-theme", "dark");
          // Cookies.set('theme', 'dark');
          document.cookie = "theme=dark; path=/";

          $('.change-icon').removeClass('bi bi-moon-stars-fill');
          $('.change-icon').addClass('bi bi-sun');
        } else {
          $("#html").attr("data-bs-theme", "light");
          // Cookies.set('theme', 'light');
          document.cookie = "theme=light; path=/";

          $('.change-icon').removeClass('bi bi-sun');
          $('.change-icon').addClass('bi bi-moon-stars-fill');
        }
    });
});

// Toggle sidebar

$('.js-sidebar-toggle').on('click', function () {
  if ($('.js-sidebar').hasClass('collapsed')) {
    $('.js-sidebar').removeClass('collapsed');
    $('.hamburger').removeClass('bi-x');
    $('.hamburger').addClass('bi-list');

  } else {
    $('.js-sidebar').addClass('collapsed');
    $('.hamburger').removeClass('bi-list');
    $('.hamburger').addClass('bi-x');
  }
});

// Select all checkboxes

$('body').on('click', '.select-all', function(event) {
  if (this.checked) { // check select status
      $(this).closest('table').find('.checkbox-item').each(function() { //loop through each checkbox
          this.checked = true; //select all checkboxes with class "checkbox1"
      });
  } else {
      $(this).closest('table').find('.checkbox-item').each(function () { //loop through each checkbox
          this.checked = false; //deselect all checkboxes with class "checkbox1"
      });
  }
});

// Toggle visibility

$('body').on('click', '.btn-visibility', function () {
  var thisObj = this;
  url = window.location.origin + $(this).data('link') + '/' + $(this).data('itemid');
  // if (confirm('Sigur vrei sa pui pe invizibil?')) {
  $.ajax({
    url: $(this).data('link') + '/' + $(this).data('itemid'),
    type: 'POST',
    async: true,
    cache: false,
    data: {
      state: $(this).data('state')
    },
    beforeSend: function () {

      $(thisObj).children('i').removeClass().addClass('bi bi-arrow-repeat');
    },
    success: function (data) {
      if (data.state > 0) $(thisObj).children('i').removeClass().addClass('bi bi-eye');
      else $(thisObj).children('i').removeClass().addClass('bi bi-eye-slash');
      $(thisObj).data('state', data.state);
    },
    error: function () {
      if ($(thisObj).data('state') > 0) $(thisObj).children('i').removeClass().addClass('bi bi-eye');
      else $(thisObj).children('i').removeClass().addClass('bi bi-eye-slash');
    }
  });

  return false;
});

$('body').on('click', '.visibility-all', function () {
  $(".checkbox-item:checkbox:checked").each(function () {
    $("#" + $(this).data("itemid")).find(".btn-visibility").click();
  });
});

// Delete all selected

$('body').on('click', '.delete-all', function (e) {
  var ids = '';
  $(".checkbox-item:checkbox:checked").each(function () {
      ids += ',' + $(this).data('itemid');
  });
  if (ids !== '') {
      $('#mini-modal-window .modal-content').load($(this).data('link') + "/" + ids.substring(1) + "/delete");
      var MyModal = new bootstrap.Modal('#mini-modal-window', {});
      console.log(MyModal);

      MyModal.show();
  }
  return false;
});

// ASYNC Search

var typingTimer;
var doneTypingInterval = 500;

$('#cautare').keyup(function (e) {
  e.preventDefault();
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
  return false;
});

$('#cautare').keydown(function (e) {
  clearTimeout(typingTimer);
});

function doneTyping() {
  $.ajax({
    url: $('#cautare').attr('action'),
    type: 'GET',
    async: true,
    cache: false,
    data: $('#cautare').serialize(),
    beforeSend: function () {
      $('.items').html('<h3 class="text-center"><i class="bi bi-arrow-repeat"></i></h3>');
    },
    success: function (data) {
      $('.items').html(data);
    }
  });
  return false;
}

$('#cautare').submit(function (e) {
  e.preventDefault();
  return false;
});

