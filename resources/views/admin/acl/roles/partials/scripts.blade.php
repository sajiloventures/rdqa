 <script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function() {


        // PAGE RELATED SCRIPTS

        /*$('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');*/
        /*$('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e) {*/
        $('.tree').find('li:has(ul)').attr('role', 'treeitem').find(' > span').on('click', function(e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(':visible')) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
            }
            e.stopPropagation();
        });

        $(".checkbox-inline").change(function() {
            // save state of parent
            c = $(this).is(':checked');
            $(this).parent().parent().find("input[type=checkbox]").each(function() {
                // set state of siblings
                $(this).prop('checked', c);
                recursiveTravelChildToParent($(this));
            })
        });

        // Update parent checkbox based on children
        $("input[type=checkbox]:not('.parent_checkbox')").change(function() {
            recursiveTravelChildToParent($(this));
        });


    });


    function recursiveTravelChildToParent(node, action) {

        if (node.closest('ul').parent('li').find('.parent_checkbox').length > 0) {

            if (node.closest("ul").find("input[type=checkbox]:not('.parent_checkbox')").not(':checked').length < 1)
                node.closest('ul').parent('li').find('.parent_checkbox').first().prop('checked', true);
            else
                node.closest('ul').parent('li').find('.parent_checkbox').first().prop('checked', false);

            recursiveTravelChildToParent(node.closest('ul').parent('li').find('.parent_checkbox').first(), action);

        }
    }

    function recursiveTravelParentToChild(node) {

        if (node.find("input[type=checkbox]:not('.parent_checkbox')").not(':checked').length < 1) {

            node.find("input[type=checkbox]").prop('checked', true);

        } else {

            if (node.hasClass('parent_li')) {

                node.find('ul[role="group"]').find('li[class="parent_li"]').each(function( index, elem ) {

                    recursiveTravelParentToChild($(this));

                });

            }

        }

    }

</script>