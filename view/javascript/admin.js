$(document).ready(function() {

  const currentPath = window.location.pathname; 
  const links = document.querySelectorAll(`a[href="${currentPath}"]`);  
  links.forEach(link => link.classList.add("active")); 

  $('tr[data-href]').click(function() {
    window.location = $(this).data('href');
  });

  $('.user-delete').click(function() {
    var userID = $(this).closest('tr').find('td:first-child').text();

    $.ajax({
      url: 'api/remove/user',
      method: 'POST',
      data: { id: userID },
      success: function() {
        window.location.href = 'http://localhost/IJssalon/50249/admin/users';
      },
    });
  });


  $('#product-image').on('change', function() {
    const file = $(this).prop('files')[0];
    const reader = new FileReader();

    reader.readAsDataURL(file);
    
    reader.onload = function(e) {
      $('#preview-image').attr('src', e.target.result);
    }
  });

});

