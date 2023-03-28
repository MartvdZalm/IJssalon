$(document).ready(function() {
  
  $('.menu-toggle').click(function() {
    $(this).toggleClass('active');
    $('nav ul').toggleClass('active');
    if ($('.logo').is(':hidden')) {
      $('.logo').css('display', 'block');
    } else {
      $('.logo').css('display', 'none');
    }
  });

  $(document).click(function(e) {
    var container = $('header');
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $('.logo').css('display', 'block');
      $('.menu-toggle').removeClass('active');
      $('nav ul').removeClass('active');
    }
  });


  // select all "Order" buttons
  const orderButtons = document.querySelectorAll('.order-button');

  // add event listener to each "Order" button
  orderButtons.forEach(button => {
    button.addEventListener('click', () => {
      const productId = button.getAttribute('data-id');

      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.push({id: productId});
      localStorage.setItem('cart', JSON.stringify(cart));
    });
  });

  function cartProducten()
  {
    // Retrieve data from localstorage
    var cartData = localStorage.getItem("cart");

    $.ajax({
      url: 'api/cart',
      type: 'POST',
      data: cartData,
      success: function(response) {
        $('.cart-products').html(response);

        // Get all remove buttons
        const removeButtons = document.querySelectorAll('.remove-button');
        
        // Loop through each remove button and add a click event listener
        removeButtons.forEach(button => {
          button.addEventListener('click', () => {
            // Get the product ID from the data-id attribute
            var productId = button.getAttribute('data-id');
  
            var cartData = localStorage.getItem("cart");
            var cartArray = JSON.parse(cartData);

            var index = cartArray.findIndex(function(item) {
              return item.id === productId; // replace "3" with the ID of the item you want to remove
            });

            cartArray.splice(index, 1);

            localStorage.setItem("cart", JSON.stringify(cartArray));
            cartProducten();
          });
        });
      },
    });
  }

  cartProducten();

  if (window.location.href == 'http://localhost/IJssalon/cart') {
    const orderForm = document.querySelector('#order-form');

    orderForm.addEventListener('submit', event => {
      event.preventDefault();
    
      const formData = new FormData(orderForm);
      const cartData = localStorage.getItem('cart');
      
      formData.append('cart', cartData);    
  
      $.ajax({
        url: 'api/makeOrder',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
          if (data) {
            console.log(data);
          } else {
            localStorage.clear();
            window.location.href = "http://localhost/IJssalon/message/order";
          }
        },
      });
    });
  }

});

