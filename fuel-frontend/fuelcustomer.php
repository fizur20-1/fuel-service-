<!DOCTYPE html>


<head>
  <a href="index.php">HOME </a><br>
  <h3>CUSTOMER</h3>
  <style>
    table,
    tr,
    th,
    td {
      border: 1px solid black;
      text-align: center;
    }
  </style>
</head>

<body>
  <button name="btnsignin" id='btnsignin'>Sign In</button>
  <button name="btnsignup" id='btnsignup'>Sign Up</button>

  <form id="formlogin" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <input type="text" id='username' name="username" placeholder="Username">
    <input type="text" id='password' name="password" placeholder="Password">
    <button name="btnuserlogin" id='btnuserlogin'>Login</button>
  </form>
  <form id="formregister" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <input type="text" id='rusername' name="rusername" placeholder="Username">
    <input type="text" id='rpassword' name="rpassword" placeholder="Password">
    <input type="text" id='rphone' name="rphone" placeholder="Phone">
    <button name="btnuserreg" id='btnuserreg'>Register</button>
  </form>
  <br>
  <input type="text" id='usernamelogin' name="usernamelogin" hidden readonly>

  <button name="btnshop" id='btnshop' hidden>Shop</button>
  <button name="btnhistory" id='btnhistory' hidden>Order History</button>
  <div id="divshop" hidden>
    <br><u>SHOP</u><br>
    <table id="tableshop" style="width: max-content;">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Name</th>
          <th>Product Rate</th>
          <th>In Stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
    </table>
  </div>
  <div id="divcart" hidden>
    <br><u>CART</u><br>
    <table id="tablecart" style="width: max-content;">
      <thead>
        <tr>
          <th>Cart ID</th>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Rate</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
    </table>
    <p id="totalcost"></p>
    <button id='btnorder' name='btnorder'>Order Now</button>
    <p id="orderresult"></p>
  </div>

  <div id="divhistory" hidden>
    <br><u>ORDER HISTORY</u><br>
    <table id="tablehistory" style="width: max-content;">
      <thead>
        <tr>
          <th>Cart ID</th>
          <th>Total Cost</th>
          <th>Time</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
    </table>
  </div>
  <div id="divorderdetails" hidden>
    <br><u>ORDER DETAILS</u>
    <p id="historycartid"></p>
    <table id="tableorderdetails" style="width: max-content;">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Product Name</th>
          <th>Product Rate</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
    </table>
  </div>
</body>

<script src="jquery3.6.0.js"></script>
<script>
  var allElements = ["btnsignin", "btnsignup", "formlogin", "formregister",
    "divshop", 'divcart', 'divhistory', 'divorderdetails'
  ]
  var uname = '';
  var hash = '';
  var cartId = '';
  let apiUrl = {
    userId: 'http://localhost:8081/Fuel_Service_war_exploded/customer/customer-id',
    userLogin: `http://localhost:8081/Fuel_Service_war_exploded/register/login-customer`,
    userRegister: `http://localhost:8081/Fuel_Service_war_exploded/register/customer`,
    shop: 'http://localhost:8081/Fuel_Service_war_exploded/customer/shop',

    getCart(cart_id) {
      return `http://localhost:8081/Fuel_Service_war_exploded/customer/get-cart/${cart_id}`
    },
    addToCart: 'http://localhost:8081/Fuel_Service_war_exploded/customer/add-to-cart',
    removeFromCart(product_id, cart_id) {
      return `http://localhost:8081/Fuel_Service_war_exploded/customer/remove/${product_id}/from-cart/${cart_id}`
    },
    order: 'http://localhost:8081/Fuel_Service_war_exploded/customer/order',
    orderHistory: 'http://localhost:8081/Fuel_Service_war_exploded/customer/order-history',
  }
  $(document).ready(function() {
    $('#btnsignin').click(function() {
      visibleElements(["formlogin", "btnsignup", ]);
    })
  })
  $(document).ready(function() {
    $('#btnsignup').click(function() {
      visibleElements(["formregister", "btnsignin"]);
    })
  })
  $(document).ready(function() { //btnUserLogin
    $('#btnuserlogin').click(function() {
      var username = document.getElementById('username').value;
      uname = username;
      var password = document.getElementById('password').value;
      hash = btoa(username + ':' + password) // `Basic ${hash}`
      $.ajax({
        url: apiUrl.userLogin,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'text',
        success: function(result) {
          toggleView(['usernamelogin', "btnshop", "btnhistory"], "block")
          visibleElements([]);
          document.getElementById('usernamelogin').value = result;

          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  })
  $(document).ready(function() { //btnUserRegister
    $('#btnuserreg').click(function() {
      var username = document.getElementById('rusername').value;
      var password = document.getElementById('rpassword').value;
      var phone = document.getElementById('rphone').value;

      $.ajax({
        url: apiUrl.userRegister,
        type: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "username": username,
          "password": password,
          "phone": phone,
          "enabled": true
        }),
        dataType: "json",
        success: function(result) {
          redirect("index.php?newreg=customer");
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    })
  })
  $(document).ready(function() { //#btnShop
    $('#btnshop').click(function() {
      visibleElements(["divshop"])
      if (cartId) {
        toggleView(["divcart"], "block");
        $.ajax({
          url: apiUrl.getCart(cartId),
          type: "GET",
          headers: {
            'Authorization': `Basic ${hash}`,
          },
          data: {},
          dataType: "json",
          success: function(result) {
            $("#tablecart tbody").empty()
            var totalCost = 0;
            for (var i = 0; i < result.length; i++) {
              totalCost += result[i].product.price;
              var temp = '<tr><td>' + result[i].cart_id + '</td>';
              temp += '<td>' + result[i].product.id + '</td>';
              temp += '<td>' + result[i].product.name + '</td>';
              temp += '<td>' + result[i].product.price + '</td>';
              temp += '<td><button class="btnRemove">Remove</button></td></tr>';
              $('#tablecart tbody').append(temp);
            }
            document.getElementById('totalcost').innerHTML = `<em><strong>Total Cost : ${totalCost}<strong></em>`;

            console.log(result)
          },
          error: function(err) {
            console.log(err.responseText);
          }
        })
      }
      $.ajax({
        url: apiUrl.shop,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',
        success: function(result) {
          $("#tableshop tbody").empty()

          for (var i = 0; i < result.length; i++) {
            var temp = '<tr><td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].name + '</td>';
            temp += '<td>' + result[i].price + '</td>';
            temp += '<td>' + result[i].in_stock + '</td>';
            if (result[i].in_stock) temp += '<td><button class="btnSelect">';
            else temp += '<td><button class="btnSelect" disabled>';
            temp += 'Add to cart</button></td></tr>';
            $('#tableshop tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btnAddtoCart
    $("#tableshop").on('click', '.btnSelect', function() {
      visibleElements(["divshop", 'divcart'])
      var currentRow = $(this).closest("tr");
      var productId = currentRow.find("td:eq(0)").text();
      if (!cartId) {
        $("#tablecart tbody").empty()
        cartId = Math.round(Date.now() / 1000);
      }

      $.ajax({
        url: apiUrl.addToCart,
        type: "POST",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "cart_id": cartId,
          "product": {
            "id": productId
          }
        }),
        dataType: "json",

        success: function(result) {
          $("#tablecart tbody").empty()
          var totalCost = 0;
          for (var i = 0; i < result.length; i++) {
            totalCost += result[i].product.price;
            var temp = '<tr><td>' + result[i].cart_id + '</td>';
            temp += '<td>' + result[i].product.id + '</td>';
            temp += '<td>' + result[i].product.name + '</td>';
            temp += '<td>' + result[i].product.price + '</td>';
            temp += '<td><button class="btnRemove">Remove</button></td></tr>';
            $('#tablecart tbody').append(temp);
          }
          document.getElementById('totalcost').innerHTML = `<em><strong>Total Cost : ${totalCost}<strong></em>`;

          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    });
  });
  $(document).ready(function() { //#btnRemoveFromCart
    $("#tablecart").on('click', '.btnRemove', function() {
      visibleElements(["divshop", 'divcart'])
      var currentRow = $(this).closest("tr");
      var productId = currentRow.find("td:eq(1)").text();
      if (!cartId) {
        return console.log('No Cart Id to Remove');
        // $("#tablecart tbody").empty()
        // cartId = Math.round(Date.now() / 1000);
      }

      $.ajax({
        url: apiUrl.removeFromCart(productId, cartId),
        type: "DELETE",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: {},
        dataType: "json",

        success: function(result) {
          $("#tablecart tbody").empty()
          var totalCost = 0;
          if (!result.length) {
            toggleView(['divcart'], 'none');
            cartId = '';
          }
          for (var i = 0; i < result.length; i++) {
            totalCost += result[i].product.price;
            var temp = '<tr><td>' + result[i].cart_id + '</td>';
            temp += '<td>' + result[i].product.id + '</td>';
            temp += '<td>' + result[i].product.name + '</td>';
            temp += '<td>' + result[i].product.price + '</td>';
            temp += '<td><button class="btnRemove">Remove</button></td></tr>';
            $('#tablecart tbody').append(temp);
          }
          document.getElementById('totalcost').innerHTML = `<em><strong>Total Cost : ${totalCost}<strong></em>`;

          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    });
  });
  $(document).ready(function() { //#btnOrder
    $('#btnorder').click(function() {
      // var userId = '';
      // // Get Id
      // $.ajax({
      //   url: apiUrl.userId,
      //   async: true,
      //   crossDomain: true,
      //   type: "GET",
      //   headers: {
      //     'Authorization': `Basic ${hash}`,
      //   },
      //   data: {},
      //   dataType: 'text',
      //   success: function(result) {
      //     userId = result;
      //     console.log(result)
      //   },
      //   error: function(err) {
      //     console.log("err-", err.responseText);
      //   }
      // })
      //$(this).prop('disabled', true);
      if (!cartId) {
        document.getElementById('orderresult').innerHTML = `Already ordered the cart - ${cartId}`;
        return;
      }
      // Order
      $.ajax({
        url: apiUrl.order,
        async: true,
        crossDomain: true,
        type: "POST",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "id": cartId
        }),
        dataType: 'json',
        success: function(result) {
          document.getElementById('orderresult').innerHTML = `<em><strong>Orderd cart - ${result.id}<strong></em>`;
          cartId = '';
          $('.btnRemove').attr('disabled', 'disabled');
          // //enable button:
          //   $('#button_id').removeAttr('disabled');
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btnHistory
    $('#btnhistory').click(function() {
      visibleElements(["divhistory"])

      $.ajax({
        url: apiUrl.orderHistory,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',
        success: function(result) {
          $("#tablehistory tbody").empty()
          //   <tr>
          //   <th>Cart ID</th>
          //   <th>Total Cost/th>
          //   <th>Time</th>
          //   <th>Status</th>
          //   <th>Action</th>
          // </tr>
          for (var i = result.length - 1; 0 <= i; i--) {
            //time
            var orderTime //= new Date(eval(result[i].timestamp * 1000).toLocaleString());
            orderTime = new Date(result[i].timestamp * 1000).toLocaleString()
            var temp = '<tr><td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].total_cost + '</td>';
            temp += '<td>' + orderTime + '</td>';
            temp += '<td>' + result[i].status + '</td>';
            temp += '<td><button class="btnOrderDetails">Details</button></td></tr>';

            $('#tablehistory tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btnOrderDetails
    $("#tablehistory").on('click', '.btnOrderDetails', function() {
      visibleElements(["divorderdetails", 'divhistory'])
      var currentRow = $(this).closest("tr");
      var cartId = currentRow.find("td:eq(0)").text();
      var totalCost = currentRow.find("td:eq(1)").text();
      var status = currentRow.find("td:eq(3)").text();
      // <tr>
      //       <th>Product ID</th>
      //       <th>Product Name</th>
      //       <th>Product Rate</th>
      //     </tr>
      $.ajax({
        url: apiUrl.getCart(cartId),
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`,
        },
        data: {},
        dataType: "json",
        success: function(result) {
          $("#tableorderdetails tbody").empty()
          document.getElementById('historycartid').innerHTML = `<em>Cart ID : ${cartId}<br>` +
            `Total Cost : ${totalCost}<br>Status : ${status}</em>`;

          for (var i = 0; i < result.length; i++) {
            //var temp = '<tr><td>' + result[i].product.id + '</td>';
            var temp = '<tr><td>' + (i + 1) + '</td>';
            temp += '<td>' + result[i].product.name + '</td>';
            temp += '<td>' + result[i].product.price + '</td>';
            $('#tableorderdetails tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    });
  });

  function visibleElements(elements) {
    allElements.forEach(_e => {
      var y = document.getElementById(_e);
      if (y) {
        if (elements.includes(_e) && y.style.display != "block") {
          y.style.display = "block";
        } else if (!elements.includes(_e) && y.style.display != "none")
          y.style.display = "none";
      }
    })
  }

  function toggleView(x, state) {
    x.forEach(element => {
      var y = document.getElementById(element);
      if (y.style.display != state)
        y.style.display = state;
    });
  }
</script>

</html>