<html>
<?php   
    function opr(){
        if($_GET['key']==10){
            storeInvoice();
        }
        else if($_GET['key']==9){
            selectcname();
        }
        else if($_GET['key']==8){
            updateData(1);
        }
        else if($_GET['key']==7){
            setData(1);
        }
        else if($_GET['key']==6){
            readData(1);
        }
        else if($_GET['key']==5){
            insertData(1);            
        }
        else if($_GET['key']==4){
            invoiceData();
        }
        else if($_GET['key']==3){
            updateData(0);
        }
        else if($_GET['key']==2){
            setData(0);
        }
        else if($_GET['key']==1){
            readData(0);
        }
        else{
            insertData(0);
        }
    }         
    function insertData($x){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);
        if($x==0){
            $iname=$_GET['iname'];
            $qnt=$_GET['qnt'];
            $sprc=$_GET['sprc'];
            $bprc=$_GET['bprc'];
            $vname=$_GET['vname'];
            $vadrs=$_GET['vadrs'];
            $vnos=$_GET['vnos'];
            $tdate=$_GET['tdate'];
            $query = "insert into StockDetail(itemname,quantity,retail,purchase,vname,vadrs,vnos,trandate) values('$iname','$qnt','$sprc','$bprc','$vname','$vadrs','$vnos','$tdate')";            
        }
        else{
            $cname=$_GET['cname'];
            $cadrs=$_GET['cadrs'];
            $cnos=$_GET['cnos'];            
            $query = "insert into customerdetail(cname,cadrs,cnos) values('$cname','$cadrs','$cnos')";
        }
        if($conn->query($query)){
            echo "Succefully Inserted";
        }   
        else{
            echo "Something Goes Wrong";
        }                                 
    }
    function invoiceData(){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);
        $query = "select * from StockDetail";
        $obj =  $conn->query($query); ?>      
        <div class="page-header">
            <h5>CHOOSE ITEMS YOU WANT TO BUY.</h5>           
        </div>   
        <div class="card">             
            <?php
                echo "<table class='table'>
                <tr>
                <th><a style='cursor: pointer'>Itemname</a></th>
                <th><a style='cursor: pointer'>Quantity</a></th>
                <th><a style='cursor: pointer'>Retail</a></th>                        
                <th><a style='cursor: pointer'>Total Amount</a></th>                        
                </tr>";
                while($row1 = mysqli_fetch_array($obj)) {
                    echo "<tr>";
                    echo "<td><label class='list-group-item list-group-item-action'><input id='".$row1['itemname']."checkbox' type='checkbox' onchange=go(this.value,this.checked,'".$row1['itemname']."','".$row1['retail']."') />" . $row1['itemname'] . "</td>";                    
                    echo "<td><select id='".$row1['itemname']."' onchange=go(".$row1['itemname']."checkbox.value,".$row1['itemname']."checkbox.checked,'".$row1['itemname']."','".$row1['retail']."') >";
                    for($i=1;$i<$row1['quantity'];$i++){
                        echo "<option>".$i."</option>";
                    }
                    echo "</select></td>";                    
                    echo "<td><div id='".$row1['itemname']."price'>" . $row1['retail'] . "</div></td>";
                    echo "<td><div style='display: none' class='list-group-item list-group-item-action' id='".$row1['itemname']."total'></div></td>";
                    echo "</tr>";                                                            
                }        
                echo "</table>";                                        
                echo "<button type='button' class='btn btn-primary' onclick=processInvoice()>Next</button><br>";
                echo "<button type='button' class='btn btn-secondary' onclick=mdisp(1)>Previous</button>";
                mysqli_close($conn);
            ?>                        
        </div>
        <?php        
    }
    function readData($x){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);
        if($x==0){
            $query = "select itemname from StockDetail";
            $itemname =  $conn->query($query); ?><div class="list-group">        
        <?php
            while($row1 = $itemname->fetch_assoc()){?>         
                <a onclick="viewItem('<?php echo $row1['itemname']; ?>',0)" class="list-group-item list-group-item-action" style="cursor: pointer; font-weight: bold"><?php echo $row1['itemname']; ?></a>
        <?php
            }?></div>        
    <?php
        }
        else{
            $query = "select cname from customerdetail";
            $cname =  $conn->query($query); ?><div class="list-group">        
        <?php
            while($row1 = $cname->fetch_assoc()){?>         
                <a onclick="viewItem('<?php echo $row1['cname']; ?>',1)" class="list-group-item list-group-item-action" style="cursor: pointer; font-weight: bold"><?php echo $row1['cname']; ?></a>
        <?php
            }?></div>        
    <?php
        }
        mysqli_close($conn);
    }
    function setData($x){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);
        if($x==0){
            $iname = $_GET['iname'];
            $query = "select * from StockDetail where itemname='$iname'";
            $obj =  $conn->query($query);

            echo "<table class='table'>
            <tr>
            <th><a onclick=change('itemname') style='cursor: pointer'>Itemname</a></th>
            <th><a onclick=change('quantity') style='cursor: pointer'>Quantity</a></th>
            <th><a onclick=change('retail') style='cursor: pointer'>Retail</a></th>
            <th><a onclick=change('purchase') style='cursor: pointer'>Purchase</a></th>
            <th><a onclick=change('vname') style='cursor: pointer'>Vendor name</a></th>
            <th><a onclick=change('vadrs') style='cursor: pointer'>Vendor address</a></th>
            <th><a onclick=change('vnos') style='cursor: pointer'>Vendor nos</a></th>
            </tr>";
            while($row1 = mysqli_fetch_array($obj)) {
                echo "<tr>";
                echo "<td>" . $row1['itemname'] . "</td>";
                echo "<td>" . $row1['quantity'] . "</td>";
                echo "<td>" . $row1['retail'] . "</td>";
                echo "<td>" . $row1['purchase'] . "</td>";
                echo "<td>" . $row1['vname'] . "</td>";
                echo "<td>" . $row1['vadrs'] . "</td>";
                echo "<td>" . $row1['vnos'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><input id='uinp' type='text' class='form-control' style='display: none'/></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><button type='button' class='btn btn-primary' onclick='updateData(uinp.value,0)'>Submit</button><br></td>";
                echo "</tr>";
            }
        
            echo "</table>";                                        
        }
        else{
            $cname = $_GET['cname'];
            $query = "select * from customerdetail where cname='$cname'";
            $obj =  $conn->query($query);

            echo "<table class='table'>
            <tr>
            <th><a onclick=change('cname') style='cursor: pointer'>Customer name</a></th>
            <th><a onclick=change('cadrs') style='cursor: pointer'>Customer address</a></th>
            <th><a onclick=change('cnos') style='cursor: pointer'>Customer nos</a></th>
            </tr>";
            while($row1 = mysqli_fetch_array($obj)) {
                echo "<tr>";                
                echo "<td>" . $row1['cname'] . "</td>";
                echo "<td>" . $row1['cadrs'] . "</td>";
                echo "<td>" . $row1['cnos'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><input id='uinp' type='text' class='form-control' style='display: none'/></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><button type='button' class='btn btn-primary' onclick='updateData(uinp.value,1)'>Submit</button><br></td>";
                echo "</tr>";
            }
        
            echo "</table>";                                        
        }
        mysqli_close($conn);
    }
    function updateData($x){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);                        
        $field = $_GET['field'];
        $ufield = $_GET['ufield'];
        if($x==0){
            $iname = $_GET['iname'];        
            $query = "update StockDetail set $field = '$ufield' where itemname = '$iname'";
        }        
        else{
            $cname = $_GET['cname'];
            $query = "update customerdetail set $field = '$ufield' where cname = '$cname'";
        }
        $conn->query($query); 
        mysqli_close($conn);               
    }
    function selectcname(){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);                        
        $query = "select cname from customerdetail";
        $cname =  $conn->query($query); ?>
        <div class="card" >
        <div class="form-group">
            <label for="customersel">Select Customer Id:</label>
            <select class="form-control" id="customersel">        
        <?php
            while($row1 = $cname->fetch_assoc()){?>         
                <option><?php echo $row1['cname']; ?></option>
        <?php
            }?></select><br>
                <div class="form-group">
                    <label for="tdat">TransactionDate:</label>
                    <input type="date" class="form-control" id="tdat" placeholder="Enter TransactionDate" name="tdat" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>                
            </div>
            <button type="button" class="btn btn-primary" onclick="storeInvoice(customersel.value,tdat.value)">SUBMIT</button><br>
            <button type="button" class="btn btn-secondary" onclick="processInvoice()">GO BACK</button>
            </div>            
    <?php
        mysqli_close($conn);
    }
    function storeInvoice(){  
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "interntime";
        $conn = new mysqli($hostname, $username, $password, $database);                                
        $cname = $_GET['cname'];
        $trandate = $_GET['trandate'];      
        $itemar =  json_decode($_GET['itemar']);        
        $qntar =  json_decode($_GET['qntar']);    
        for($i=0;$i<count($qntar);$i++){
            $query1 = "insert into transactiondetail(cname,itemname,quantity,trandate) values('$cname','$itemar[$i]','$qntar[$i]','$trandate')";
            $query2 = "update StockDetail set quantity = quantity - '$qntar[$i]' where itemname = '$itemar[$i]'";
            $conn->query($query1);                
            $conn->query($query2);                
        }        
        mysqli_close($conn);    
    }
    opr();

?>
</html>