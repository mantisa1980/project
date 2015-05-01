<Table border=1>
    <th>id</th><th>name</th><th colspan="1">email</th>
    <tr>
        <td name="key" class="data" >1</td>
        <td name="name" class="data">許功蓋</td>
        <td name="email" class="data">abc@123.com</td>
        <td><input type="button" name="fetch_js_form_post.php" value="title1" onClick="reply_click(this)"></td>
        <td><input type="button" name="fetch_js_form_post.php" value="title2" onClick="reply_click(this)"></td>
        <input type="hidden" class="hidden_key" name="hidden_key1" value="XXX">
        <input type="hidden" class="hidden_key" name="hidden_key2" value="YYY">
    </tr>
    <tr>
        <td name="key" class="data">2</td>
        <td name="name" class="data">吳明峰</td>
        <td name="email" class="data">xyz@456.com</td>
        <td><input type="button" name="fetch_js_form_post.php" value="title1" onClick="reply_click(this)"></td>
        <td><input type="button" name="fetch_js_form_post.php" value="title2" onClick="reply_click(this)"></td>
        <input type="hidden" class="hidden_key" name="hidden_key1" value="AAA">
        <input type="hidden" class="hidden_key" name="hidden_key2" value="BBB">
    </tr>
</table>

<script type="text/javascript">
function reply_click(sender)
{
    var elem = sender.parentNode.parentNode;
    //var elem = document.getElementById("t1");
    //var childs = elem.getElementsByTagName("td");

    console.log("sender name=" + sender.name);
    var childs = elem.getElementsByClassName("data");

    console.log("td count=" + childs.length);

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", sender.name);

    for (i=0; i < childs.length; i++)
    {
        console.log(childs[i].getAttribute("name")+"," + childs[i].innerHTML);// cannot use elem.name. ok for elem.id.... WTF!

        var input = document.createElement("input");
        input.type  = "text";
        input.name  = childs[i].getAttribute("name");
        input.value = childs[i].innerHTML;
        form.appendChild(input);
    }

    var childs = elem.getElementsByClassName("hidden_key");
    for (i=0; i < childs.length; i++)
    {
        console.log(childs[i].getAttribute("name")+"," + childs[i].value);

        var input = document.createElement("input");
        input.type  = "text";
        input.name  = childs[i].getAttribute("name");
        input.value = childs[i].value;
        form.appendChild(input);
    }
    
    form.submit();

}
</script>