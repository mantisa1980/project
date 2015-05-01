<script type="text/javascript">
var counter = 1;

function on_add_input_row()
{
    var tbody = document.getElementById("tbody");
    var tr = document.getElementById("tr"+ (counter-1) );  // get latest tr
    var clone=tr.cloneNode(true);
    clone.setAttribute("id", "tr"+ (counter) );
    tbody.appendChild(clone);
    counter+=1;
}

function on_submit_order_insert()
{
    var tbody = document.getElementById("tbody");
    var post_data = [];

    for (i=0; i< counter; i++)
    {
        var tr = document.getElementById("tr"+i);
        //console.log("tr=" + tr);

        var item = tr.getElementsByClassName("item");
        var item_value = item[0].value;

        var unit = tr.getElementsByClassName("unit");
        var unit_value = unit[0].value;

        var amount = tr.getElementsByClassName("amount");
        var amount_value = amount[0].value;

        var unit_price = tr.getElementsByClassName("unit_price");
        var unit_price_value = unit_price[0].value;

        if(amount_value == null || amount_value == "")
        {
            alert("單位數量輸入錯誤!");
            return;
        }
        if(unit_price_value == null || unit_price_value == "")
        {
            alert("單位價格輸入錯誤!");
            return;
        }

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
