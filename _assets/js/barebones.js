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
