$(document).ready(function() {

  const currentPath = window.location.pathname; 
  const links = document.querySelectorAll(`a[href="${currentPath}"]`);  
  links.forEach(link => link.classList.add("active")); 

  $('tr[data-href]').click(function() {
    window.location = $(this).data('href');
  });

  $('.btn-delete').click(function() {
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

});

