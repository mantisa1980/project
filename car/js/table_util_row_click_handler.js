<script type="text/javascript">
var last_click_button = null;
var last_tr_before_edit = null;

function on_table_util_sendout_click(sender)
{
    var elem = sender.parentNode.parentNode; // <tr><td><sender here is a input button>
    var form = document.createElement("form");
    form.style.visibility="hidden";
    
    form.setAttribute("method", "post");
    form.setAttribute("action", sender.name);  // set click handler here 
    //alert("sender.name=" + sender.name);
    var childs = elem.getElementsByClassName("readonly_text");

    // append a row's visible text fields ( by getting name 'text_data') to the form
    for (i=0; i < childs.length; i++)
    {
        //console.log(childs[i]);
        var input = document.createElement("input");
        input.type  = "text";
        input.name  = childs[i].getAttribute("name");
        input.value = childs[i].innerHTML;
        //alert("1: input.name=" + input.name + " value=" + input.value);
        form.appendChild(input);
    }

    var childs = elem.getElementsByClassName("editable_text");

    // append a row's visible fields ( by getting name 'text_data') to the form
    for (i=0; i < childs.length; i++)
    {
        //console.log(childs[i]);
        var input = document.createElement("input");
        input.type  = "text";
        input.name  = childs[i].getAttribute("name");
        input.value = childs[i].childNodes[0].value;
        //alert("2: input.name=" + input.name + " value=" + input.value);
        form.appendChild(input);
    }

    // append a row's invisible fields ( by getting name 'hiden_key') to the form
    var childs = elem.getElementsByClassName("hidden_key");
    for (i=0; i < childs.length; i++)
    {
        //console.log(childs[i]);
        var input = document.createElement("input");
        input.type  = "text";
        input.name  = childs[i].getAttribute("name");
        input.value = childs[i].value;
        //alert("3: input.name=" + input.name + " value=" + input.value);
        form.appendChild(input);
    }

    document.body.appendChild(form);  // 不加這行只有Chrome可以跑 其他都不行...
    form.submit();
}

function on_table_util_modify_click(sender)
{
    
    // for each tr , get all editable texts, recover their values and button status

    if ( last_click_button != null)
    {
        // 消除上一個編輯到一半的狀態
        last_click_button.setAttribute("onClick", "on_table_util_modify_click(this)");
        //last_click_button.value = "編輯";
        last_click_button.value = last_tr_before_edit.getElementsByClassName("modify_button")[0].value;
//
        // 用備份還原編輯到一半放棄的資料
        var childs = last_click_button.parentNode.parentNode.getElementsByClassName("editable_text");
        var childs_origin = last_tr_before_edit.getElementsByClassName("editable_text");
        for (i=0; i < childs.length; i++)
        {
            // 模擬DBTableUtility 輸出input type = text的地方
            childs[i].innerHTML = childs_origin[i].innerHTML;
            childs[i].value = childs_origin[i].value;
        }
    }

    last_click_button = sender;
    last_tr_before_edit = sender.parentNode.parentNode.cloneNode(true);

    var elem = sender.parentNode.parentNode; // <tr><td><sender here is a input button>
    
    // change button state 
    sender.setAttribute("onClick", "on_table_util_sendout_click(this)");
    sender.value = "送出";
    var childs = elem.getElementsByClassName("editable_text");

    for (i=0; i < childs.length; i++)
    {
        //console.log(childs[i]);
        var value = childs[i].innerHTML;
        // 模擬DBTableUtility 輸出input type = text的地方
        childs[i].innerHTML = '<input type="text" value="'+value+'">';
    }
}

function on_table_util_alert_click(sender, alert_message)
{
    var r = confirm(alert_message);
    if( r == true) 
    {
        //alert("OK");
        on_table_util_sendout_click(sender);
    }
}

</script>
