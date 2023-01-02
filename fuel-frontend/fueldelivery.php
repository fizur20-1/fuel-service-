<!DOCTYPE html>

<head>
  <a href="index.php">HOME </a><br>
  <h3>DELIVERY</h3>
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

  <button name="btnpending" id='btnpending' hidden>Pending Orders</button>
  <div id="divpending" hidden>
    <br><u>PENDING ORDERS</u>
    <table id="tablepending" style="width: max-content;">
      <thead>
        <tr>
          <th>Sl No</th>
          <th>Order ID</th>
          <th>Customer ID</th>
          <th>Total Cost</th>
          <th>Order Time</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
    </table>
  </div>
  <div id="divorderdetails" hidden>
    <br><u>ORDER DETAILS</u><br>
    Order ID : <input type="text" id='sorderid' name="sorderid" readonly><br>
    Order Time: <input type="text" id='sordertime' name="sordertime" readonly>
    Customer ID: <input type="text" id='sordercid' name="sordercid" readonly><br>
    Customer Name: <input type="text" id='sordercname' name="sordercname" readonly><br>
    Customer Phone: <input type="text" id='sordercphone' name="sordercphone" readonly><br>
    Availability: <input type="text" id='savailablibity' name="savailablibity" readonly><br>
    Total Weight : <input type="text" id='sordertweight' name="sordertweight" readonly><br>
    Total Cost : <input type="text" id='sordertprice' name="sordertprice" readonly><br>
    <button name="btnaccept" id='btnaccept'>Accept</button>
    <p id="deliveryresult">
  </div>
</body>

<script src="jquery3.6.0.js"></script>
<script>
  var allElements = ["btnsignin", "btnsignup", "formlogin", "formregister",
    "divpending", "divorderdetails"
  ]
  var uname = '';
  var hash = '';
  var deliveryId = '';

  let apiUrl = {
    getCustomerinfo(customer_id) {
      return `http://localhost:8081/Fuel_Service_war_exploded/delivery/customer-info/${customer_id}`
    },
    userLogin: `http://localhost:8081/Fuel_Service_war_exploded/register/login-delivery`,
    userRegister: `http://localhost:8081/Fuel_Service_war_exploded/register/delivery`,

    getCart(cart_id) {
      return `http://localhost:8081/Fuel_Service_war_exploded/delivery/get-cart/${cart_id}`
    },
    pendingOrders: `http://localhost:8081/Fuel_Service_war_exploded/delivery/pending-orders`,
    acceptDelivery(delivery_id) {
      return `http://localhost:8081/Fuel_Service_war_exploded/delivery/accept-delivery/${delivery_id}`
    }
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
          toggleView(['usernamelogin', "btnpending"], "block")
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
          redirect("index.php?newreg=delivery");
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    })
  })
  $(document).ready(function() { //#btnPending
    $('#btnpending').click(function() {
      visibleElements(["divpending"])
      $.ajax({
        url: apiUrl.pendingOrders,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',
        success: function(result) {
          $("#tablepending tbody").empty()
          for (var i = 0; i < result.length; i++) {
            var orderTime = new Date(result[i].timestamp * 1000).toLocaleString()
            var temp = '<tr><td>' + (i + 1) + '</td>';
            temp += '<td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].customer_id + '</td>';
            temp += '<td>' + result[i].total_cost + '</td>';
            temp += '<td>' + orderTime + '</td>';
            temp += '<td><button class="btnDeliveryDetails">Details</button></td></tr>';

            $('#tablepending tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btnDeliveryDetails
    $("#tablepending").on('click', '.btnDeliveryDetails', function() {
      visibleElements(["divpending", "divorderdetails"])
      var currentRow = $(this).closest("tr");
      var orderId = currentRow.find("td:eq(1)").text();
      deliveryId = orderId;
      var customerId = currentRow.find("td:eq(2)").text();
      var totalCost = currentRow.find("td:eq(3)").text();
      var orderTime = currentRow.find("td:eq(4)").text();
      var a, b, c;
      // Get Customer info
      $.ajax({
        url: apiUrl.getCustomerinfo(customerId),
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: {},
        dataType: "json",
        success: function(result) {
          a = result.name;
          b = result.phone;
          c = result.enabled;
          console.log(result);
        },
        error: function(err) {
          console.log(err.responseText);
        }
      }).then(() => { // Get Products in a Cart
        $.ajax({
          url: apiUrl.getCart(orderId),
          async: true,
          crossDomain: true,
          type: "GET",
          headers: {
            'Authorization': `Basic ${hash}`,
          },
          data: {},
          dataType: "json",
          success: function(cart) {
            document.getElementById('sorderid').value = orderId;
            document.getElementById('sordertime').value = orderTime;
            document.getElementById('sordercid').value = customerId;
            document.getElementById('sordercname').value = a;
            document.getElementById('sordercphone').value = b;
            document.getElementById('savailablibity').value = c;
            document.getElementById('sordertweight').value = cart.length;
            document.getElementById('sordertprice').value = totalCost;

            console.log(cart)
          },
          error: function(err) {
            console.log(err.responseText);
          }
        })
      })
    });
  });
  $(document).ready(function() { //btnAcceptDelivery
    $('#btnaccept').click(function() {
      if (!deliveryId) {
        document.getElementById('deliveryresult').innerHTML = `Already accepted the delivery!`;
        return;
      }
      $.ajax({
        url: apiUrl.acceptDelivery(deliveryId),
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'text',
        success: function(result) {
          document.getElementById('deliveryresult').innerHTML = result;
          deliveryId = '';
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  })

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