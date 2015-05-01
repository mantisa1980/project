

<script type="text/javascript">
function reply_click(sender)
{
    //var parent = sender.parentNode.parentNode;
    //alert("sender.parentNode.parentNode=" + parent.id);
    var elem = sender.parentNode.parentNode;
    //var elem = document.getElementById("t1");
    var childs = elem.getElementsByTagName("td");
    console.log(childs.length);
    console.log(elem.getAttribute("id") +"," + childs[0].getAttribute("name") +"," + childs[1].getAttribute("name")+"," + childs[2].getAttribute("name"));// cannot use elem.name. ok for elem.id.... WTF!
    console.log(elem.getAttribute("id") +"," + childs[0].innerHTML +"," + childs[1].innerHTML+"," + childs[2].innerHTML);
    //var form = document.createElement("form");
    //form.setAttribute("method", "post");
   // form.setAttribute("action", "update.php");
   
   
}
</script>

<form method="post" action="update.php">
</form>

<Table border=1>
    <th>id</th><th>name</th><th colspan="1">email</th>
    <tr id="t1">
        <td name="key">1</td>
        <td name="name">許功蓋</td>
        <td name="email">abc@123.com</td>
        <td><input type="button" name="btn1" value="Modify" onClick="reply_click(this)"></td>
    </tr>
    <tr id="t2">
        <td name="key">2</td><td>吳明峰</td>
        <td name="name">xyz@456.com</td>
        <td name="email"><input type="button" name="btn2" value="Modify" onClick="reply_click(this)"></td>
    </tr>

</table>


