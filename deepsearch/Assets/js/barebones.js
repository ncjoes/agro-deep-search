/**
 * Created by Chukwuemeka on 2/1/2016.
 */

function checker(arr_name, button_id)
{
    function check_all(class_name)
    {
        var items = document.getElementsByName(class_name);
        for(var i = 0; i < items.length; i++){var itm = items[i]; itm.setAttribute('checked','checked');}
    }

    function uncheck_all(class_name)
    {
        var items = document.getElementsByName(class_name);
        for(var i = 0; i < items.length; i++){var itm = items[i]; itm.removeAttribute('checked');}
    }
    var button = document.getElementById(button_id);
    if(button.hasAttribute('checked'))
    {
        button.removeAttribute('checked');
        uncheck_all(arr_name);
    }
    else
    {
        button.setAttribute('checked', 'checked');
        check_all(arr_name);
    }
}

function filterSubList(parent_id, child_id)
{
    var parent_list_options = document.getElementById(parent_id).childNodes;
    var selected = '';

    for(var i = 0; i < parent_list_options.length; ++i)
    {
        var option = parent_list_options[i];
        if(option.selected){ selected = option.value; break; }
    }

    if(selected != '')
    {
        selected = 'c'+selected;
        var child_list_options = document.getElementById(child_id).options;

        for(var j=0; j < child_list_options.length; ++j)
        {
            var current_option = child_list_options[j];
            if(current_option.getAttribute('class') == selected)
            {
                current_option.setAttribute("style", "display:block !important;");
            }
            else if(current_option.getAttribute('class') != 'c0'){
                current_option.setAttribute("style", "display:none !important;")
            }
        }
    }
}

function toggleNodeDisplay(node_selector)
{
    var node = document.getElementById(node_selector);
    var display = node.getAttribute('style');
    if(display == 'display:block')
        node.setAttribute('style', 'display:none');
    else
        node.setAttribute('style', 'display:block');
}

function showNode(nodeId) {
    document.getElementById(nodeId).setAttribute('style','display:block;')
}
function hideNode(nodeId) {
    document.getElementById(nodeId).setAttribute('style','display:none;')
}


function makeHttpRequest()
{
    try {return new XMLHttpRequest();}
    catch (e) {}
    try {return new ActiveXObject("Msxml2.XMLHTTP");}
    catch (e) {}
    try {return new ActiveXObject("Microsoft.XMLHTTP");}
    catch (e) {}
}

function httpRequestResponse(code)
{
    var rs = '';
    switch(code)
    {
        case 404: rs = ' 404 : Page Not Found.'; break;
        case 414: rs = ': Request URL too long for the server.'; break;
        case 0: rs = ': Can not establish http connection.'; break;
        default : rs = ': Unknown Type.'; break;
    }
    return rs;
}
function htmlGetRequest(url, params, actions)
{
    var requestObject = makeHttpRequest();
    requestObject.open('GET', url + '?' + params, true);
    requestObject.send(null);
    requestObject.onreadystatechange = function()
    {
        if(requestObject.readyState == 4)
        {
            if (requestObject.status == 200)
            {
                var response = requestObject.responseText;
                if(actions != null){return actions(response);}
                else{alert(response);}
            }else{
                alert('Error '+httpRequestResponse(requestObject.status));
            }
        }
    }
}
