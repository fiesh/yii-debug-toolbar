
<table id="yii-debug-toolbar-ajax-response">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo YiiDebug::t("Source"); ?></th>
        <th><?php echo YiiDebug::t("Status"); ?></th>
        <th><?php echo YiiDebug::t("Url"); ?></th>
        <th><?php echo YiiDebug::t("Response"); ?></th>
    </tr>
    </thead>
</table>


<script type="text/javascript">
    /**
     * Encodes html string to display in log
     * @param s
     */
    function HtmlEncode(s) {
        var el = document.createElement("div");
        el.innerText = el.textContent = s;
        s = el.innerHTML;
        delete el;
        return s;
    }

    // set up event
    $(function(){
        // bind ajax event
        $('#yii-debug-toolbar').on("ajaxComplete", function(event, xmlrequest, ajaxOptions){
            // compute text to put into response td
            // html encode it, remove extra spaces and new lines, and reduce to 100 characters
            var $text = HtmlEncode(xmlrequest.responseText).replace(/[\s\n\r]+/g, ' ').substr(0,100);

            // add a new row to ajax table
            $('#yii-debug-toolbar-ajax-response').append(
                '<tr class="even">' +
                    '<td class="hilight">' + $('#yii-debug-toolbar-ajax-response tr').size() +'<\/td>' +
                    '<td class="hilight">jQuery ' + jQuery.fn.jquery + '<\/td>' +
                    '<td class="hilight">' + xmlrequest.statusText + ' (' + xmlrequest.status + ')<\/td>' +
                    '<td class="hilight">' + ajaxOptions.url + '<\/td>' +
                    '<td class="hilight">' + $text + '<\/td>' +
                    '<\/tr>'
            );

            // stripe table
            $('#yii-debug-toolbar-ajax-response tbody tr:nth-child(even)').attr('class', 'odd');

            // update count in toolbar
            var currentNum = parseInt($('span#num_ajax').html());
            $('span#num_ajax').html(currentNum + 1);

        });
    });
</script>