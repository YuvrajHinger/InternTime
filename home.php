<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Page Title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" media="screen" href="css/w3css.css"/>        
        <script>
            var ciname,ccname,field,arrItem = [],Itime=0,disp = '';
            function mdisp(x){            
                backInvoice();
                iname.value = '';                
                qnt.value = '';
                sprc.value = '';
                bprc.value = '';
                vname.value = '';
                vadrs.value = '';
                vnos.value = '';
                tdate.value = '';  
                arrItem = [];         
                showreport.style.display = 'none';                                                                                                 
                invoiceForm.style.display = 'none';                                                                                             
                finalInvoice.style.display = 'none';                   
                readData.style.display = 'none';
                cform.style.display = 'none';                                          
                adform.style.display='none';                                  
                show.style.display='none';
                hide.style.display='none';               
                if(x==1){
                    show.style.display='block';                    
                    return;
                } 
                else if(x==2){
                    showreport.style.display = 'block';
                    return;
                }                               
                hide.style.display='block';                                
            }
            function ajaxMethod(x){ 
                if(x==0){                                               
                    if(iname.value == '' || qnt.value == '' || sprc.value == '' || bprc.value == '' || vname.value == '' || vadrs.value == '' || vnos.value == '' || tdate.value == ''){
                        alert("Please Fill Out All Field");
                        return;
                    }                
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {                                           
                            alert("Successfully Inserted");                                            
                            iname.value = '';                
                        }
                    };                
                    xmlhttp.open("GET","dbhandle.php?key=0&iname="+iname.value+"&qnt="+qnt.value+"&sprc="+sprc.value+"&bprc="+bprc.value+"&vname="+vname.value+"&vadrs="+vadrs.value+"&vnos="+vnos.value+"&tdate="+JSON.stringify(tdate.value),true);
                    xmlhttp.send();
                    return;
                }
                if(cname.value == '' || cadrs.value == '' || cnos.value == ''){
                        alert("Please Fill Out All Field");
                        return;
                }                
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {                                           
                            alert("Successfully Inserted");                                            
                            cname.value = '';                
                    }
                };                
                xmlhttp.open("GET","dbhandle.php?key=5&cname="+cname.value+"&cadrs="+cadrs.value+"&cnos="+cnos.value,true);
                xmlhttp.send();
            }
            function readAjax(x){ 
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {                         
                        mdisp(0);
                        readData.style.display = 'block';                  
                        readData.innerHTML = this.responseText;                                                       
                    }
                };
                if(x==0){
                    xmlhttp.open("GET","dbhandle.php?key=1",true);
                }                                                 
                else{
                    xmlhttp.open("GET","dbhandle.php?key=6",true);
                }          
                xmlhttp.send();
            }
            function viewForm(x){                
                mdisp(0);                
                adform.style.display='block';
                if(x=='c'){                  
                    adform.style.display='none';  
                    cform.style.display = 'block';                                                              
                }                          
            }
            function viewItem(x,y){
                xmlhttp = new XMLHttpRequest();                
                if(y==0){   
                    ciname=x;                 
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {                                                                        
                            readData.style.display = 'block';  
                            readData.innerHTML = this.responseText;                                          
                        }
                    };                
                    xmlhttp.open("GET","dbhandle.php?key=2&iname="+x,true);
                }
                else{
                    ccname=x;                 
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {                                                                        
                            readData.style.display = 'block';  
                            readData.innerHTML = this.responseText;                                          
                        }
                    };                
                    xmlhttp.open("GET","dbhandle.php?key=7&cname="+x,true);
                }
                xmlhttp.send();
            }
            function updateData(x,y){
                if(x==''){
                    arrItem = []
                    readAjax(y);
                    return;
                }
                xmlhttp = new XMLHttpRequest();
                if(y==0){                    
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {                                 
                            alert("succesfully updated");
                            if(field=='itemname'){                            
                                ciname = x;
                            }
                            uinp.value = '';
                            uinp.style.display='none';
                            viewItem(ciname,0);                        
                        }
                    };                
                    xmlhttp.open("GET","dbhandle.php?key=3&iname="+ciname+"&field="+field+"&ufield="+x,true);
                }
                else{
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {                                 
                            alert("succesfully updated");
                            if(field=='cname'){                            
                                ccname = x;
                            }
                            uinp.value = '';
                            uinp.style.display='none';
                            viewItem(ccname,1);                        
                        }
                    };                
                    xmlhttp.open("GET","dbhandle.php?key=8&cname="+ccname+"&field="+field+"&ufield="+x,true);
                }
                xmlhttp.send();
            }
            function change(x){
                field=x;
                uinp.placeholder=x;
                uinp.type='text';
                uinp.style.display='block';
                if(x=='quantity' || x=='retail' || x=='purchase' || x=='vnos'){
                    uinp.type='number';                    
                }
            }
            function invoiceShow(){
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {   
                        mdisp(1);                                                    
                        readData.style.display = 'block';                           
                        readData.innerHTML = this.responseText;                                                       
                    }
                };                
                xmlhttp.open("GET","dbhandle.php?key=4",true);
                xmlhttp.send();       
            }
            function go(value,flag,id,per){                                              
                for(i=0;i<arrItem.length;i++){
                    if(arrItem[i]==id){
                        arrItem.splice(i,1);
                    }
                }
                totalprice = id.concat('total');                                
                document.getElementById(totalprice).style.display = 'none';                                                   
                if(flag==true){                              
                    arrItem.push(id);
                    document.getElementById(totalprice).style.display = 'block';     
                    Amt = per*document.getElementById(id).value;                                  
                    document.getElementById(totalprice).innerHTML = Amt;
                }                
                if(Itime==1){               
                    processInvoice();
                }
            }
            function processInvoice(){
                if(arrItem.length<1){
                    alert("Please Select Atleast One Item");
                    return;
                }
                finalInvoice.style.display = 'none';                  
                Itime=1;
                totalPrice = 0;
                readData.style.display = 'none';                                          
                invoiceForm.style.display = 'flex';
                disp = '';            
                disp+= "<div class='page-header'><h5>INVOICE TO BE IN PROCESS.</h5></div>";
                disp+="<div class='card'><table class='table'><tr>";
                disp+="<th><a style='cursor: pointer'>Itemname</a></th>";
                disp+="<th><a style='cursor: pointer'>Quantity</a></th>";
                disp+="<th><a style='cursor: pointer'>Retail</a></th>";
                disp+="<th><a style='cursor: pointer'>Total Amount</a></th></tr><tr>";                
                for(i=0;i<arrItem.length;i++){                                    
                    mkid = arrItem[i].concat('price');                                                                                               
                    qnt = document.getElementById(arrItem[i]).value;
                    prc = document.getElementById(mkid).innerHTML;
                    mkid = arrItem[i].concat('total');                                                                                               
                    amt = document.getElementById(mkid).innerHTML;
                    disp+='<td><label class="list-group-item list-group-item-action">'+arrItem[i]+'</td>';                                        
                    disp+='<td><label class="list-group-item list-group-item-action">'+qnt+'</td>';    
                    disp+='<td><label class="list-group-item list-group-item-action">'+prc+'</td>';    
                    disp+='<td><label class="list-group-item list-group-item-action">'+amt+'</td></tr>';                        
                    totalPrice = totalPrice + Number(amt);
                }  
                disp+='';
                disp+='<tr><th>Total Amount</th><td></td><td></td><td><label class="list-group-item list-group-item-action">'+totalPrice+'</td></tr></table>';                       
                disp+='<button type="button" class="btn btn-primary" onclick="selectcname()">Submit</button><br>'; 
                disp+='<button type="button" class="btn btn-secondary" onclick="backInvoice()">Go Back</button><br>'; 
                invoiceForm.innerHTML = disp;                
            }
            function selectcname(){                
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {   
                        invoiceForm.style.display = 'none';                                                                                             
                        finalInvoice.style.display = 'block';                  
                        finalInvoice.innerHTML = this.responseText;                                                       
                    }                    
                };   
                xmlhttp.open("GET","dbhandle.php?key=9",true);                                                              
                xmlhttp.send();
            }
            function storeInvoice(x,y){
                y = JSON.stringify(y); 
                var qntar = [];
                for(i=0;i<arrItem.length;i++){
                    qntar.push(document.getElementById(arrItem[i]).value);
                }                                                  
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {    
                        alert("TRANSACTION SUCEESS");   
                        mdisp(1);                    
                    }                    
                };
                xmlhttp.open("GET","dbhandle.php?key=10&cname="+x+"&trandate="+y+"&itemar="+JSON.stringify(arrItem)+"&qntar="+JSON.stringify(qntar),true);                                                              
                xmlhttp.send();                                
            }
            function backInvoice(){
                Itime=0;                
                readData.style.display = 'block';                                          
                invoiceForm.style.display = 'none';
            } 
            function grn(){
                alert("COMING SOON");
            }
            function transdetail(){
                alert("COMING SOON");
            }
            function sdetail(){
                alert("COMING SOON");
            }           
        </script>
    </head>


    <body>
        <div class="jumbotron text-center">
            <h1>TASK 1</h1>            
        </div>
        <div class="container">            
            <div class="card">
                <div id="show">
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="mdisp(0)">MASTER</button>                
                    </div>
                    <!-- <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="mdisp(2)">REPORT</button>
                    </div> -->
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="invoiceShow()">INVOICE</button>
                    </div>                                
                </div>             
            
            













                <div id="hide" style="display: none">
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="viewForm('i')">ADD ITEMS</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="viewForm('c')">ADD CUSTOMER</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="readAjax(0)">UPDATE ITEMS</button>                
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="readAjax(1)">UPDATE CUSTOMER</button>                
                    </div>                    
                    <button class="btn btn-secondary" type="button" onclick="mdisp(1)" style="float: right">PREVIOUS</button>                                
                </div>


                <div id="showreport" style="display: none">
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="transdetail()">TRANSACTION DETAIL</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="sdetail()">STOCK DETAIL</button>
                    </div>            
                    <div class="btn-group">
                        <button class="btn btn-outline-info" type="button" onclick="grn()">GRN</button>
                    </div>                                               
                    <button class="btn btn-secondary" type="button" onclick="mdisp(1)" style="float: right">PREVIOUS</button>                                
                </div>


                <form id='cform' class="was-validated" style='display: none'>

                    <div class="card">
                    <div class="form-group">
                        <label for="cname">CUSTOMERID:</label>
                        <input type="text" class="form-control" id="cname" placeholder="Enter Customerid" name="cname" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="cadrs">CUSTOMERADDRESS:</label>
                        <input type="text" class="form-control" id="cadrs" placeholder="Enter Customeraddress" name="cadrs" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="cnos">CUSTOMERCONTACT:</label>
                        <input type="tel" class="form-control" id="cnos" placeholder="Enter Customercontact" name="cnos" pattern="[0-9]{10}"  required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>                                
                    <button type="button" class="btn btn-primary" onclick="ajaxMethod(1)">Submit</button><br>
                    <button type="button" class="btn btn-secondary" onclick="mdisp(0)">Go Back</button>
                    </div>

                </form>
               
                <div id="readData" class="card" style="display: none">

                </div>                        
            
                <div id="invoiceForm" class="card" style="display: none">

                </div> 
                
                <div id="finalInvoice"  class="card" style="display: none">

                </div>  

                <form id="adform" class="was-validated" style="display: none">
                    <div class="card">
                    <div class="form-group">
                        <label for="iname">Itemname:</label>
                        <input type="text" class="form-control" id="iname" placeholder="Enter Itemname" name="iname" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="vadrs">Quantity:</label>
                        <input type="number" class="form-control" id="qnt" placeholder="Enter Quantity/Unit" name="qnt" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="sprc">Retail Price:</label>
                        <input type="number" class="form-control" id="sprc" placeholder="Enter Sailing Price/Unit" name="sprc" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="bprc">Purchase Amount:</label>
                        <input type="number" class="form-control" id="bprc" placeholder="Purchasing Price/Unit" name="bprc" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="vname">VendorId:</label>
                        <input type="text" class="form-control" id="vname" placeholder="Enter VendorId" name="vname" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="vadrs">VendorAddress:</label>
                        <input type="text" class="form-control" id="vadrs" placeholder="Enter VendorAddress" name="vadrs" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="vnos">VendorContact:</label>
                        <input type="tel" class="form-control" id="vnos" placeholder="Enter VendorContact" name="vnos" pattern="[0-9]{10}"  required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>                
                    <div class="form-group">
                        <label for="tdate">TransactionDate:</label>
                        <input type="date" class="form-control" id="tdate" placeholder="Enter TransactionDate" name="tdate" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>                
                    <button id="submitChange" type="button" class="btn btn-primary" onclick="ajaxMethod(0)">Submit</button><br>
                    <button id="PreviousChange" type="button" class="btn btn-secondary" onclick="mdisp(0)">Go Back</button>
                </form>                
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>    
</html>