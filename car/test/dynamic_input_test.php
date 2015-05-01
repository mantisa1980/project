<?php

    echo '
<html>
<head>
</head>
    <body>
        <form id="form"  method="post" action="dynamic_input_result.php">
            <input type="button" value="新增一列" onClick="on_add_input_row()">
            <input type="button" value="送出" onClick="on_submit_order_insert()">
            <table border=1>
                <thead>
                    <tr>
                        <th>品項</th>
                        <th>單位</th>
                        <th>單位數量</th>
                        <th>價格</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr id="tr0">

                        <td><select name="item" class="item">
                          <option value="1">item1</option>
                          <option value="2">item2</option>
                          <option value="3">item3</option>
                          <option value="4">item4</option>
                        </select></td>

                        <td><select name="unit" class="unit">
                          <option value="1">kg</option>
                          <option value="2">mg</option>
                        </select></td>
                        <td><input type="text" class="amount"> </td>
                        <td><input type="text" class="unit_price"> </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>
    ';
?>

<script type="text/javascript">
var counter = 1;  // counter 0 is printed using HTML code, so begin from 1

function append_selection(container, name, option_values, option_titles)
{
	var select = document.createElement("select");
    select.setAttribute("name", name);
    select.setAttribute("class", name);
    select.style.width=100;

    for (i=0;i<option_values.length;i++)
    {
    	var option = document.createElement("option");
    	option.value = option_values[i];
    	option.text = option_titles[i];
    	select.appendChild(option);
    }
    container.appendChild(select);
}

function append_text_input(container, name)
{
	var element = document.createElement("input");
    //element.type  = "text";
    element.setAttribute("type", "text");  // use setAttribute is better;element.class will fail
    element.setAttribute("class", name);
    element.setAttribute("name", name);
    element.style.width = 100;
    container.appendChild(element);
}

function on_add_input_row()
{
    console.log("counter=" + counter);
    var tbody = document.getElementById("tbody");
    var tr = document.getElementById("tr"+ (counter-1) );  // get latest tr
    var cln=tr.cloneNode(true);
    cln.setAttribute("id", "tr"+ (counter) );
    tbody.appendChild(cln);
    counter+=1;
}


function on_submit_order_insert()
{
    var tbody = document.getElementById("tbody");
    var post_data = [];

    for (i=0; i< counter; i++)
    {
        var tr = document.getElementById("tr"+i);
        console.log("tr=" + tr);

    	var item = tr.getElementsByClassName("item");
    	var item_value = item[0].value;

    	var unit = tr.getElementsByClassName("unit");
    	var unit_value = unit[0].value;

    	var amount = tr.getElementsByClassName("amount");
    	var amount_value = amount[0].value;

    	var unit_price = tr.getElementsByClassName("unit_price");
    	var unit_price_value = unit_price[0].value;


        //json["data"].push()
        post_data.push( {"item":item_value, "unit":unit_value,"amount":amount_value ,"unit_price":unit_price_value } );

    	//console.log("item=" + item_value +",unit=" + unit_value +", amount=" + amount_value +", unit price=" + unit_price_value);
    }
    var input   = document.createElement("input");
    input.type  = "hidden";
    input.name  = "json_data";
    input.value = JSON.stringify(post_data);
    //console.log("json data=" + input.value);

    form.appendChild(input);    
    form.submit();
}
</script>
