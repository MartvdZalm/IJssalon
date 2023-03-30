$(document).ready(function()
{
  
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
      const productPrice = button.getAttribute('data-price');

      $('#alert-popup').fadeIn('slow').delay(2000).fadeOut('slow');

      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.push({id: productId});
      cart.push({price: productPrice});

      localStorage.setItem('cart', JSON.stringify(cart));
    });
  });

  if (window.location.href == 'http://localhost/IJssalon/cart') {

    function cartProducten()
    {
      var cartData = localStorage.getItem("cart");

      $.ajax({
        url: 'api/cart',
        type: 'POST',
        data: cartData,
        success: function(response) {
          $('.cart-products').html(response);
          $('#order-price').html("Price: &#8364; " + calculateTotalPrice());

          const removeButtons = document.querySelectorAll('.remove-button');
          
          removeButtons.forEach(button => {
            button.addEventListener('click', () => {
        
              var productId = button.getAttribute('data-id');
              var productPrice = button.getAttribute('data-price');
    
              var cartData = localStorage.getItem("cart");
              var cartArray = JSON.parse(cartData);

              var index = cartArray.findIndex(function(item) {
                return item.id === productId; 
              });
              cartArray.splice(index, 1);

              var index = cartArray.findIndex(function(item) {
                return item.price === productPrice; 
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

function calculateTotalPrice() {
  let products = JSON.parse(localStorage.getItem('cart'));

  let totalPrice = 0;
  for (let i = 0; i < products.length; i++) {
    if (products[i].price) {
      totalPrice += parseInt(products[i].price);
    }
  }

  return totalPrice;
}

