
<h4>jQuery <script type="text/javascript">document.write(jQuery.fn.jquery);</script></h4>
<table id="yii-debug-toolbar-ajax-response">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo YiiDebug::t("Status"); ?></th>
        <th><?php echo YiiDebug::t("Url"); ?></th>
        <th><?php echo YiiDebug::t("Response"); ?></th>
    </tr>
    </thead>
</table>


<script type="text/javascript">
    "use strict";

    /**
     * Encodes html string to display in log
     * @param s
     */
    function htmlEncode(s) {
        var el = document.createElement("div");
        el.innerText = el.textContent = s;
        s = el.innerHTML;
        return s;
    }

    // set up event
    $(function(){
        // bind ajax event
        $('#yii-debug-toolbar').on("ajaxComplete", function(event, xmlrequest, ajaxOptions){
            // compute text to put into response td
            // html encode it, remove extra spaces and new lines, and reduce to 100 characters
            var $text = htmlEncode(xmlrequest.responseText).replace(/[\s\n\r]+/g, ' ').substr(0,200);

            // add a new row to ajax table
            $('#yii-debug-toolbar-ajax-response').append(
                '<tr class="even">' +
                    '<td>' + $('#yii-debug-toolbar-ajax-response tr').size() +'<\/td>' +
                    '<td>' + xmlrequest.statusText + ' (' + xmlrequest.status + ')<\/td>' +
                    '<td>' + ajaxOptions.url + '<\/td>' +
                    '<td>' + $text + '<\/td>' +
                    '<\/tr>'
            );

            // stripe table
            $('#yii-debug-toolbar-ajax-response tbody tr:nth-child(even)').attr('class', 'odd');

            // update count in toolbar
            var currentNum = parseInt($('span#num_ajax').html(), 10);
            $('span#num_ajax').html(currentNum + 1);

        });
    });
</script>