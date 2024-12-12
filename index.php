<?php 
  include("dbConnection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css"  rel="stylesheet"  />
    <link href="style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    
</head>

<body>


<!-- Insert Modal -->
<div class="modal fade" id="insert_edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-success" id="main_title">Insert Fianic Number</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form>
  <div class="mb-1">
    <label for="firstname" class="form_label">Username:</label>
    <input id="firstname" type="text" class="form-control" name="first_name"  placeholder = "Enter Username" >
    <div id="firstHelp" style="visibility:hidden" class="text-danger fw-bold mt-1 fs-6">Enter User Name</div>
  </div>

  <div class="mb-1">
    <label for="number" class="form_label">User’s Input</label>
    <input type="number" class="form-control" name="number" id="number" placeholder = "Enter Valid Numer">
    <div id="lastHelp" style="visibility:hidden"  class="text-danger fw-bold mt-1 fs-6">Enter Valid Number</div>
  </div>



    </form>

  </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary" id="insert_update_data" name="update_data" class="btn btn-primary">Save changes</button>
       </div>
    </div>
  </div>
 </form>
</div>
</div>

   

<div class="header">
    <h1 class="header_highlight">FullStack Tasks</h1>
</div>
<div class="table_conntainer" >

<div>
   	<div>
    	<button type="button" id="insert_data" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insert_edit_modal">Calculat Fia Number</button>
   	</div>
  </div>

</div>
</div>

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>User_Name</th>
                <th>User’s Inputr</th>
                <th>Fibonacci Number</th>
                
            </tr>
        </thead>
       
    <?php 
     $query = "SELECT * FROM fiacoo";
     $sth = $dbh->prepare($query);
     $sth->execute();
     $result = $sth->fetchAll();
     
    if ($result) {
      foreach($result as $row) { ?>       
          <tr  id="<?php echo $row["username"]; ?>">

            <td class="h4 align-center"><?php echo  $row["id"]; ?><?php $row["id"] ?></td>
            <td class="h4 align-middle"><?php echo $row["user_number"]; ?></td>
            <td class="h4 align-middle"><?php echo $row["fiacon_number"]; ?></td>
              
        </tr>   
      
      <?php  } ?>
    <?php } ?>

  </tbody>

    </table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

new DataTable('#example');
function setInputObservers() {
  const firstname = document.getElementById("firstname");
  const lastname = document.getElementById("number");
  firstname.addEventListener("input", handleValueChange);
  lastname.addEventListener("input", handleValueChange);
}

setInputObservers();

function handleValueChange(e) {
     let checkedInputStr;
     let inputString = e.target.value
     console.log(e.target.value)
     checkedInputStr = inputString.replaceAll(' ', '');
     console.log(checkedInputStr)
     if (checkedInputStr.length > 0 ) {
         if (e.target.id === "firstname"){
             document.getElementById("firstHelp").style.visibility = "hidden"
         }else if (e.target.id === "number") {
              document.getElementById("lastHelp").style.visibility = "hidden"
         }
     }
}


$(function() {
    $('#insert_update_data').click(function() {
      onInsertUser(event);
    });
});

function onInsertUser(e) {
  
   let data = {};
   data["username"] = $("#firstname").val();
   data["user_number"] = $("#number").val();

   console.log(data)
   e.preventDefault();

   $.ajax({
    method: "POST",
    url: "insert.php",
    data: {
      "insert": true,
      "user_data": data
    },
    success: function(rsp) {
      console.log('dare')
     let response;
     response = JSON.parse(rsp);
     console.log(response["user"])
     let value = response["user"]
    
    
     let firstHelp = document.getElementById("firstHelp");
     let lastHelp = document.getElementById("lastHelp");
        if ((value["username"] ==="") && (value["user_number"]==="")) {
            lastHelp.style.visibility = "visible";
            firstHelp.style.visibility = "visible"
        }else if (value["username"] ==="") {
             firstHelp.style.visibility = "visible";
        }else if (value["user_number"]===""){
            lastHelp.style.visibility = "visible";
        }

       let status = response["status"];

       if (!status) {
        return
       }


       let table = document.getElementById("example");
   

       let row = document.createElement("tr");
       row.className = "table-info"

       let c1 = document.createElement("td");
       let c2 = document.createElement("td");
       let c3 = document.createElement("td");
 
    


       c1.innerText = value["username"];
       c1.className = "h4 align-middle"
      
       // secondCell populat
       c2.innerText = value["user_number"]
       c2.className = "h4 align-middle"

       // thirdCell populate
       console.log(value)
       c3.innerText = value["fianic_number"]
       c3.className = "h4 align-middle"

       // forthCell populate
     
        
       // Append cells to row
       row.appendChild(c1);
       row.appendChild(c2);
       row.appendChild(c3);

      
       // Append row to table body
       table.appendChild(row)
       $('#insert_edit_modal').modal('hide');
       onResetInsert_Edit_Modal();   
    }
   })
  }

  function onResetInsert_Edit_Modal() {
   let firstHelp = document.getElementById("firstHelp");
   let lastHelp = document.getElementById("lastHelp");
   lastHelp.style.visibility = "hidden";
   firstHelp.style.visibility = "hidden";
   $("#firstname").val("");
   $("#number").val("");
}



</script>
</body>
</html>