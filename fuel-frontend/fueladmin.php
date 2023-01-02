<html>

<head>
  <a href="index.php">Home </a><br>
  <a href="logout.php">Log Out </a><br>
  <h3>ADMIN</h3>
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

  <form id="formlogin" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <input type="text" id='username' name="username" placeholder="Username">
    <input type="text" id='password' name="password" placeholder="Password">
    <button name="btnadminlogin" id='btnadminlogin'>Login</button>
  </form>
  <br>
  <input type="text" id='usernamelogin' name="usernamelogin" hidden readonly>

  <button name="btnusers" id='btnusers' hidden>Users</button>
  <table id="tableusers" Border="1" style="width: max-content;" hidden>
    <thead>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Enabled</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
  </table>
  <form id="formuser" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <br><u>USER INFO</u><br>
    ID : <input type="text" id='suserid' name="suserid" readonly><br>
    Username: <input type="text" id='susername' name="susername"><br>
    Password: <input type="text" id='spassword' name="spassword"><br>
    Phone: <input type="text" id='sphone' name="sphone"><br>
    Role : <input type="text" id='srole' name="srole"><br>
    Enabled : <input type="text" id='senabled' name="senabled"><br>
    <button name="btnadduser" id='btnadduser'>Add</button>
    <button name="btnedituser" id='btnedituser'>Update</button>
    <button name="btndeleteuser" id='btndeleteuser'>Delete</button>
    <p id="userresult">
  </form>

  <button name="btnproducts" id='btnproducts' hidden>Products</button>
  <table id="tableproducts" Border="1" style="width: max-content;" hidden>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>In Stock</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
  </table>
  <form id="formproduct" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <br><u>PRODUCT INFO</u><br>
    ID : <input type="text" id='sproductid' name="sproductid" readonly><br>
    Name: <input type="text" id='sproductname' name="sproductname"><br>
    Price: <input type="text" id='sproductprice' name="sproductprice"><br>
    In Stock : <input type="text" id='sproductstock' name="sproductstock"><br>
    <button name="btnaddproduct" id='btnaddproduct'>Add</button>
    <button name="btneditproduct" id='btneditproduct'>Update</button>
    <button name="btndeleteproduct" id='btndeleteproduct'>Delete</button>
    <p id="productresult">
  </form>

  <button name="btnorders" id='btnorders' hidden>Orders</button>
  <table id="tableorders" Border="1" style="width: max-content;" hidden>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Customer ID</th>
        <th>Total Cost</th>
        <th>Timestamp</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
  </table>
  <form id="formorder" action="" method="post" enctype="multipart/form-data" onsubmit="return false" hidden>
    <br><u>ORDER INFO</u><br>
    Order ID : <input type="text" id='sorderid' name="sorderid" readonly><br>
    Customer ID: <input type="text" id='sordercid' name="sordercid"><br>
    Total Cost : <input type="text" id='sordertprice' name="sordertprice"><br>
    Timestamp : <input type="text" id='sordertimestamp' name="sordertimestamp">
    <input type="text" id='sorderdate' name="sorderdate" readonly><br>
    Status : <input type="text" id='sorderstatus' name="sorderstatus"><br>
    <button name="btnaddorder" id='btnaddorder'>Add</button>
    <button name="btneditorder" id='btneditorder'>Update</button>
    <button name="btndeleteorder" id='btndeleteorder'>Delete</button>
    <p id="orderresult">
  </form>
</body>

<script src="jquery3.6.0.js"></script>

<script>
  var allElements = ["btnsignin", "formlogin", 'usernamelogin',
    "btnusers", "btnSelect", "tableusers", "formuser",
    "btnproducts", "tableproducts", "formproduct",
    "btnorders", "tableorders", "formorder"
  ]
  var uname = '';
  var hash = '';
  let apiUrl = {
    adminLogin: `http://localhost:8081/Fuel_Service_war_exploded/register/login-admin`,
    // User
    allUsers: 'http://localhost:8081/Fuel_Service_war_exploded/admin/get-all-users',
    addUser: 'http://localhost:8081/Fuel_Service_war_exploded/admin/add-user',
    updateUser: 'http://localhost:8081/Fuel_Service_war_exploded/admin/update-user',
    deleteUser(userId) {
      return `http://localhost:8081/Fuel_Service_war_exploded/admin/delete-user/${userId}`
    },
    //Product
    allProducts: 'http://localhost:8081/Fuel_Service_war_exploded/admin/get-all-products',
    addProduct: 'http://localhost:8081/Fuel_Service_war_exploded/admin/add-product',
    updateProduct: 'http://localhost:8081/Fuel_Service_war_exploded/admin/update-product',
    deleteProduct(ProductId) {
      return `http://localhost:8081/Fuel_Service_war_exploded/admin/delete-product/${ProductId}`
    },
    // Order
    allOrders: 'http://localhost:8081/Fuel_Service_war_exploded/admin/get-all-orders',
    addOrder: 'http://localhost:8081/Fuel_Service_war_exploded/admin/add-order',
    updateOrder: 'http://localhost:8081/Fuel_Service_war_exploded/admin/update-order',
    deleteOrder(OrderId) {
      return `http://localhost:8081/Fuel_Service_war_exploded/admin/delete-order/${OrderId}`
    },
  }

  $(document).ready(function() { //#btnsignin
    $('#btnsignin').click(function() {
      visibleElements(["formlogin"]);
      //toggleView(["formlogin"], "block")
      //toggleView(['btnsignin'], "none")
    })
  });
  $(document).ready(function() { //#btnadminlogin
    $('#btnadminlogin').click(function() {
      var username = document.getElementById('username').value;
      uname = username;
      var password = document.getElementById('password').value;

      hash = btoa(username + ':' + password) // `Basic ${hash}`
      //console.log(hash);
      $.ajax({
        url: apiUrl.adminLogin,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {

          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'text',

        success: function(result) {
          visibleElements(["usernamelogin", "btnusers", "btnproducts", "btnorders"])
          //toggleView(["usernamelogin", "btnusers"], "block")
          //toggleView(["formlogin"], "none")
          document.getElementById('usernamelogin').value = result;

          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  //Users
  $(document).ready(function() { //#btnUsers
    $('#btnusers').click(function() {
      visibleElements(["tableusers", 'btnusers', 'btnproducts', "btnorders"])
      //toggleView(["tableusers"], "block")
      //toggleView(['formuser'], "none"); //'btnusers',

      $.ajax({
        url: apiUrl.allUsers,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',

        success: function(result) {
          $("#tableusers tbody").empty()

          for (var i = 0; i < result.length; i++) {
            var temp = '<tr><td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].username + '</td>';
            temp += '<td>' + result[i].password + '</td>';
            temp += '<td>' + result[i].phone + '</td>';
            temp += '<td>' + result[i].authorities.map(a => a.name.split('_')[1]).join(', ') + '</td>';
            temp += '<td>' + result[i].enabled + '</td>';
            temp += '<td><button class="btnSelect">Select</button></td></tr>';
            $('#tableusers tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btnSelect
    // code to read selected table row cell data (values).
    $("#tableusers").on('click', '.btnSelect', function() {
      visibleElements(["formuser", 'tableusers', 'btnusers', 'btnproducts', "btnorders"])
      //toggleView(["formuser"], "block")

      // get the current row
      var currentRow = $(this).closest("tr");

      var id = currentRow.find("td:eq(0)").text();
      var username = currentRow.find("td:eq(1)").text();
      var password = currentRow.find("td:eq(2)").text();
      var phone = currentRow.find("td:eq(3)").text();
      var authorityId = currentRow.find("td:eq(4)").text().split(', ')[0]; //authorityId = (authorityId == 'USER' ? 1 : 2);
      var enabled = currentRow.find("td:eq(5)").text() // == 'true' ? true : false;

      document.getElementById('suserid').value = id;
      document.getElementById('susername').value = username;
      document.getElementById('spassword').value = password;
      document.getElementById('sphone').value = phone;
      document.getElementById('srole').value = authorityId;
      document.getElementById('senabled').value = enabled;

      //var data = col1 + "\n" + col2 + "\n" + col3;
      //alert(data);
    });
  });
  $(document).ready(function() { //#btnaddUser
    $('#btnadduser').click(function() {
      //toggleView(["tableusers", ], "block")
      //toggleView(['btnusers', 'formuser'], "none")
      var username = document.getElementById('susername').value;
      var password = document.getElementById('spassword').value;
      var phone = document.getElementById('sphone').value;
      var authority = document.getElementById('srole').value.toLowerCase();
      var authorityId = authority == 'admin' ? 1 : authority == 'customer' ? 2 : authority == 'delivery' ? 3 : 4;
      $.ajax({
        url: apiUrl.addUser,
        type: "POST",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "username": username,
          "password": password,
          "phone": phone,
          "authorities": [{
            "id": authorityId
          }],
          "enabled": true
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('userresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btneditUser
    $('#btnedituser').click(function() {
      //toggleView(["tableusers", ], "block")
      //toggleView(['btnusers', 'formuser'], "none")
      var userid = document.getElementById('suserid').value;
      var username = document.getElementById('susername').value;
      var password = document.getElementById('spassword').value;
      var phone = document.getElementById('sphone').value;
      var authority = document.getElementById('srole').value.toLowerCase();
      var authorityId = authority == 'admin' ? 1 : authority == 'customer' ? 2 : authority == 'delivery' ? 3 : 4;
      var enabled = document.getElementById('senabled').value == 'false' ? false : true;
      $.ajax({
        url: apiUrl.updateUser,
        async: true,
        crossDomain: true,
        type: "PUT",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "id": userid * 1,
          "username": username,
          "password": password,
          "phone": phone,
          "authorities": [{
            "id": authorityId
          }],
          "enabled": enabled
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('userresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('userresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btndeleteUser
    $('#btndeleteuser').click(function() {
      //toggleView(["tableusers", ], "block")
      //toggleView(['btnusers', 'formuser'], "none")
      var userId = document.getElementById('suserid').value;
      $.ajax({
        url: apiUrl.deleteUser(userId),
        type: "DELETE",
        headers: {
          'Content-Type': 'application/json'
        },
        data: {},
        dataType: "text",

        success: function(result) {
          document.getElementById('userresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('userresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });
  //Products
  $(document).ready(function() { //#btnproducts
    $('#btnproducts').click(function() {
      visibleElements(["tableproducts", 'btnusers', 'btnproducts', "btnorders"])

      $.ajax({
        url: apiUrl.allProducts,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',

        success: function(result) {
          $("#tableproducts tbody").empty()
          for (var i = 0; i < result.length; i++) {
            var temp = '<tr><td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].name + '</td>';
            temp += '<td>' + result[i].price + '</td>';
            temp += '<td>' + result[i].in_stock + '</td>';
            temp += '<td><button class="btnSelect">Select</button></td></tr>';
            $('#tableproducts tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#tableProducts
    $("#tableproducts").on('click', '.btnSelect', function() {
      visibleElements(['btnusers', 'btnproducts', 'tableproducts', "btnorders", "formproduct"])
      var currentRow = $(this).closest("tr");

      var id = currentRow.find("td:eq(0)").text();
      var productname = currentRow.find("td:eq(1)").text();
      var price = currentRow.find("td:eq(2)").text();
      var in_stock = currentRow.find("td:eq(3)").text();

      document.getElementById('sproductid').value = id;
      document.getElementById('sproductname').value = productname;
      document.getElementById('sproductprice').value = price;
      document.getElementById('sproductstock').value = in_stock;
    });
  });
  $(document).ready(function() { //#btnaddProduct
    $('#btnaddproduct').click(function() {
      visibleElements(['btnusers', 'btnproducts', "btnorders", 'tableproducts', "formproduct"])

      var productname = document.getElementById('sproductname').value;
      var price = document.getElementById('sproductprice').value;
      $.ajax({
        url: apiUrl.addProduct,
        type: "POST",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "name": productname,
          "price": price,
          "in_stock": true
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('productresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btneditProduct
    $('#btneditproduct').click(function() {
      visibleElements(['btnusers', 'btnproducts', "btnorders", 'tableproducts', "formproduct"])

      var productid = document.getElementById('sproductid').value;
      var productname = document.getElementById('sproductname').value;
      var price = document.getElementById('sproductprice').value;
      var in_stock = document.getElementById('sproductstock').value;
      $.ajax({
        url: apiUrl.updateProduct,
        async: true,
        crossDomain: true,
        type: "PUT",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "id": productid * 1,
          "name": productname,
          "price": price,
          "in_stock": in_stock
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('productresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('productresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btndeleteProduct
    $('#btndeleteproduct').click(function() {
      visibleElements(['btnusers', 'btnproducts', "btnorders", 'tableproducts', "formproduct"])

      var productId = document.getElementById('sproductid').value;
      $.ajax({
        url: apiUrl.deleteProduct(productId),
        type: "DELETE",
        headers: {
          'Content-Type': 'application/json'
        },
        data: {},
        dataType: "text",

        success: function(result) {
          document.getElementById('productresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('productresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });
  //Orders
  $(document).ready(function() { //#btnorders
    $('#btnorders').click(function() {
      visibleElements(["tableorders", 'btnusers', 'btnproducts', 'btnorders'])

      $.ajax({
        url: apiUrl.allOrders,
        async: true,
        crossDomain: true,
        type: "GET",
        headers: {
          'Authorization': `Basic ${hash}`
        },
        data: {},
        dataType: 'json',
        success: function(result) {
          $("#tableorders tbody").empty()
          for (var i = result.length - 1; 0 <= i; i--) {
            var temp = '<tr><td>' + result[i].id + '</td>';
            temp += '<td>' + result[i].customer_id + '</td>';
            temp += '<td>' + result[i].total_cost + '</td>';
            temp += '<td>' + result[i].timestamp + '</td>';
            temp += '<td>' + result[i].status + '</td>';
            temp += '<td><button class="btnSelect">Select</button></td></tr>';
            $('#tableorders tbody').append(temp);
          }
          console.log(result)
        },
        error: function(err) {
          console.log("err-", err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#tableOrders click .btnSelect
    $("#tableorders").on('click', '.btnSelect', function() {
      visibleElements(['btnusers', 'btnproducts', 'btnorders', 'tableorders', "formorder"])
      var currentRow = $(this).closest("tr");

      var id = currentRow.find("td:eq(0)").text();
      var customer_id = currentRow.find("td:eq(1)").text();
      var total_cost = currentRow.find("td:eq(2)").text();
      var timestamp = currentRow.find("td:eq(3)").text();
      var status = currentRow.find("td:eq(4)").text();

      document.getElementById('sorderid').value = id;
      document.getElementById('sordercid').value = customer_id;
      document.getElementById('sordertprice').value = total_cost;
      document.getElementById('sordertimestamp').value = timestamp;
      document.getElementById('sorderdate').value = new Date(timestamp * 1000).toLocaleString();
      document.getElementById('sorderstatus').value = status;

    });
  });
  $(document).ready(function() { //#btnaddOrder
    $('#btnaddorder').click(function() {
      visibleElements(['btnusers', 'btnproducts', 'btnorders', 'tableorders', "formorder"])

      var customer_id = document.getElementById('sordercid').value;
      var total_cost = document.getElementById('sordertprice').value;
      var timestamp = document.getElementById('sordertimestamp').value;
      var status = document.getElementById('sorderstatus').value;
      $.ajax({
        url: apiUrl.addOrder,
        type: "POST",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "id": Math.round(Date.now() / 1000),
          "customer_id": customer_id,
          "total_cost": total_cost,
          "timestamp": timestamp,
          "status": status
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('orderresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btneditOrder
    $('#btneditorder').click(function() {
      visibleElements(['btnusers', 'btnproducts', 'btnorders', 'tableorders', "formorder"])

      var orderid = document.getElementById('sorderid').value;
      var customer_id = document.getElementById('sordercid').value;
      var total_cost = document.getElementById('sordertprice').value;
      var timestamp = document.getElementById('sordertimestamp').value;
      var status = document.getElementById('sorderstatus').value;

      $.ajax({
        url: apiUrl.updateOrder,
        async: true,
        crossDomain: true,
        type: "PUT",
        headers: {
          'Authorization': `Basic ${hash}`,
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          "id": orderid * 1,
          "customer_id": customer_id,
          "total_cost": total_cost,
          "timestamp": timestamp,
          "status": status
        }),
        dataType: "text",

        success: function(result) {
          document.getElementById('orderresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('orderresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });
  $(document).ready(function() { //#btndeleteOrder
    $('#btndeleteorder').click(function() {
      visibleElements(['btnusers', 'btnproducts', 'btnorders', 'tableorders', "formorder"])

      var orderId = document.getElementById('sorderid').value;
      $.ajax({
        url: apiUrl.deleteOrder(orderId),
        type: "DELETE",
        headers: {
          'Content-Type': 'application/json'
        },
        data: {},
        dataType: "text",

        success: function(result) {
          document.getElementById('orderresult').innerHTML = result;
          console.log(result)
        },
        error: function(err) {
          document.getElementById('orderresult').innerHTML = err.responseText;
          console.log(err.responseText);
        }
      })
    })
  });

  function toggleView(x, state) {
    x.forEach(element => {
      var y = document.getElementById(element);
      if (y.style.display != state)
        y.style.display = state;
    });
  }

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

  function redirect(url) {
    window.location.assign(url);
  }
</script>

</html>