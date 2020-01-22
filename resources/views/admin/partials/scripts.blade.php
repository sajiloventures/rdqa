
<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write("Html::script('smartadmin/js/jquery.js')");
    }

</script>
{!! Html::script('js/app.js') !!}
{!! Html::script('smartadmin/js/all.js') !!}
{!! Html::script('assets/js/site.js') !!}
{{--stripe verification--}}
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
{!! Html::script('assets/js/jquery.creditCardValidator.js') !!}
<script type="text/javascript">
    // This identifies your website in the createToken call below
    //Stripe.setPublishableKey("pk_test_WDh6i5uvD9PjqJp1nhtC5f3I");
    // Create a Stripe client

    var stripe = Stripe('{!! env('STRIPE_TEST_PUBLIC') !!}');
</script>
{!! Html::script('assets/js/card-verify.js') !!}


{{--google maps--}}
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&v=3.exp&key= AIzaSyASDas1DeXVMz-Qn8WsNaj9z0z-DeBSUdQ "></script>
<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {
        pageSetUp();
          // $(".chosen-select").chosen();
           /*
             * TIMEPICKER
             */

            $('.timepicker').timepicker();

            $('.datetimepicker').datetimepicker();
            
            /*
             * CLOCKPICKER
             */
            $('.clockpicker').clockpicker({
                placement: 'top',
                donetext: 'Done'
            });

            $('.summernote').summernote({
                    height: 200,
                    toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]

                  ]
                });

        /* // DOM Position key index //

         l - Length changing (dropdown)
         f - Filtering input (search)
         t - The Table! (datatable)
         i - Information (records)
         p - Pagination (paging)
         r - pRocessing
         < and > - div elements
         <"#id" and > - div with an id
         <"class" and > - div with a class
         <"#id.class" and > - div with an id and class

         Also see: http://legacy.datatables.net/usage/features
         */

        /* BASIC ;*/
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };
//    add toekn in x-editable form

        /* END BASIC */
        //alert($('#left-panel').height());
        $('#content').css('min-height', (window.outerHeight)+'px');


    });
    /*setup config*/
    var Config = {
        base_url: "{{ url('/')}}"
    };

    function loadUrl(newLocation) {
        window.location = newLocation;
    }
    /*
     * SmartAlerts for delete items
     */
    // With Callback
    $(".deleteMe").click(function(e) {

        var url = $(this).data('url');
        var data = $(this).data('data');
        var id = this;
//            console.log($(this).parent().parent());
        $.SmartMessageBox({
            title : "Delete Confirmation!",
            content : "Are You sure want to remove this?",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {
                /*delete item using ajax*/
                $.ajax({
                    context: data,
                    type: "DELETE",
                    url: url,
                });
                /*remove parent tr*/
                $(id).closest('tr').remove();
                /*show alert*/
                $.smallBox({
                    title : "Deleted!",
                    content : "<i class='fa fa-clock-o'></i> <i>Selected item deleted..</i>",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }
            if (ButtonPressed === "No") {
                $.smallBox({
                    title : "Cancel Process",
                    content : "<i class='fa fa-clock-o'></i> <i>You pressed No...</i>",
                    color : "#C46A69",
                    iconSmall : "fa fa-times fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        e.preventDefault();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script>
    var host = window.location.hostname;

//    var socket = io.connect('http://' + host);
//     var socket = io('http://localhost:3000');
   var socket = io.connect('http://'+host+':3000',       {
                'reconnection': true,
                'reconnectionDelay': 1000,
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 5
            });

    socket.on("public-announcements-channel:App\\Events\\AnnounceEvent", function(message){
        console.log(message.data);
        // increase the power everytime we load test route
        $('#unreadcount').text(parseInt($('#unreadcount').text()) + 1);
        $.smallBox({
            title : "You have new notification!",
            content : "<i class='fa fa-message'></i> <i>"+message.data.title+"</i>",
            color : "#16b0ff",
            iconSmall : "fa fa-check fa-2x fadeInRight animated",
            timeout : 4000
        });

    });
</script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        var $modal = $('#mainModal');

        $(document).on('click', '.showannouncement', function () {
            var id = $(this).data('id');
            // $('body').modalmanager('loading');
            $modal.load(Config.base_url + "/admin/announcement/show/" + id, '', function () {
                $modal.modal();
            });
        });
        $(document).on('click', '#activity', function (e) {
                 var id = $(this).data('id');
                $.get( "/admin/announcement/read/" + id, function( data ) {
                   return true;
                });
        });

</script>