// var dt = require("datatables.net")(window, $);
// var buttons = require( 'datatables.net-buttons' )( window, $ );

$('document').ready(function(){
    $('#submit').click(function(){
       
    });

    tableOperations = new tableOperations($('#soldTable'), $('#soldForm'), $('#cashPosition'), $('#closeDay'), $('#profit'), $('#sales'));
    tableOperations.load();


});

class tableOperations {
    constructor(table, saveForm, cashPosition, CloseDay, profit, sales) {
        this.table = table;
        this.saveForm = saveForm;
        this.cashPosition = cashPosition;
        this.profit = profit;
        this.sales = sales;
        var url = window.location.pathname;
        this.day_id = url.substring(url.lastIndexOf('/') + 1);

        this.saveForm.find( submit ).click(()=>{
            this.saveProduct();
        });

        CloseDay.click(() =>{
            var conf = confirm("Czy jesteś pewnien, że chcesz zamknąć dzień?");
            if(conf){
                window.location.href += "/close";
            }
        })
    }


    loading(stan){
        if(stan){
            $("#loading").removeClass("invisible");
        }else{
            $("#loading").addClass("invisible");
        }
        
    }

    load(){
        this.loading(true);
        $.ajax({
            context: this,
            url: "/day/tableSold",
            data: {
                "id": this.day_id
            },
            type : 'post',
            dataType : 'json',
            success: function(result){
                this.loadTable(result);
            } 
        });
    }

    delete(id){
        console.log(id);
    }


    loadTable(data){
        this.table.find( "tbody" ).empty();
        var table = data[0];
        var table_length = Object.keys(table).length;
        for(var i=0; i<table_length; i++){
            var tr = document.createElement("tr");
            // Product -----
            var td = document.createElement("td");
            td.innerHTML = table[i]['Product'];
            tr.append(td);
            this.table.append(tr);
            // Price -----
            var td = document.createElement("td");
            td.innerHTML = table[i]['Price'];
            tr.append(td);
            this.table.append(tr);
            // PurchasePrice -----
            var td = document.createElement("td");
            td.innerHTML = table[i]['PurchasePrice'];
            tr.append(td);
            this.table.append(tr);
            // Factue -----
            var td = document.createElement("td");
            td.innerHTML = table[i]['Facture'];
            tr.append(td);
            this.table.append(tr);
            // Sale -----
            var td = document.createElement("td");
            td.innerHTML = table[i]['Sale'];
            tr.append(td);
            this.table.append(tr);
            // Date -----
            var date = new Date(table[i]['Date']);
            var td = document.createElement("td");
            td.innerHTML = date.toLocaleTimeString();
            tr.append(td);
            this.table.append(tr);
            
            // Buttons -----
            // delete 
            var td = $("<td></td>").appendTo(tr);
            // var btn_delete = $("<button class='btn btn-danger'>delete</button>");
            var btn_delete = $("<button class='btn btn-danger'>delete</button>");
            btn_delete.click();
            var btn_edit= $("<button class='btn btn-info ml-3'>edit</button>");
            td.append(btn_delete);
            td.append(btn_edit);
            this.table.append(tr);
            
        }
         // CashPosition -----
        this.cashPosition.html(Math.round((data[1] + Number.EPSILON) * 100) / 100);
        // Profit -----
        this.profit.html(Math.round((data[3] + Number.EPSILON) * 100) / 100);
        // Sales -----
        this.sales.html(Math.round((data[2] + Number.EPSILON) * 100) / 100);

        this.loading(false);
    }

    saveProduct(){
        var data = this.saveForm.serializeArray();
        var flag = false;
        for(var i=0; i<data.length; i++){
            if(data[i].value == ""){
                flag = true;
                alert("Uzupełnij wszystkie dane.");
                break;
            }
        }
        if(flag==false){
            this.loading(true);
            $.ajax({
                context: this,
                url: "/day",
                data: {
                    "data": data
                },
                type : 'post',
                dataType : 'json',
                success: function(result){
                    this.load();
                    this.saveForm.value= "";
                } 
            });
        }
    }


  }