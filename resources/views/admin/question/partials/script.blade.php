<script>
    $(document).ready(function () {

        $('#nestable3').nestable({maxDepth: 0});

        var selectedRow = null;
        $('.dd').on('click', '.editTitle', function (e) {
            e.preventDefault();
            selectedRow = $(this);
            var data = {
                type: $(this).data('type'),
                key: $(this).data('key'),
                part: $(this).data('part')
            };
            $.post('{{ route($base_route . '.getEditModal') }}', data, function (response) {
                $('#editTitleModal').html(response).modal('show');
            }).fail(function (response) {
                selectedRow = null;
                showAlert('Error', 'Please try again after refreshing window.', false);
            });
        });


        // submit form
        $('.modal').on('submit', '#form_edit_question_title', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('[type="submit"]').append(' <i class="fa fa-spin fa-spinner"></i>');
            $.post($(this).attr('action'), $(this).serialize(), function(response) {
                parentModal.find('[type="submit"] i.fa.fa-spin').remove();
                parentModal.modal('hide');
                selectedRow.closest('.dd3-content').find('.txtTitle').html(response.title);
                showAlert('Success', response.message, true);
            }).fail(function (response) {
                showAlert('Error', 'Unsuccessful to update data', false);
            });
        });

        $('.dd').on('click', '.addQuestions', function (e) {
            e.preventDefault();
            var data = {
                id: $(this).data('id'),
                type: $(this).parent().find('.editTitle').data('type'),
                key: $(this).parent().find('.editTitle').data('key'),
                part: $(this).parent().find('.editTitle').data('part')
            };
            $.post('{{ route($base_route . '.getAddQuestionModal') }}', data, function (response) {
                $('#editTitleModal').html(response).modal('show');
            }).fail(function (response) {
                alert('error');
            });
        });

        $('.modal').on('click', '.addQuestionToList', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('.help-block').hide();
            var data = {
                note: parentModal.find('[name="noteData"]').val(),
                question: parentModal.find('[name="questionData"]').val(),
                if_not_question: parentModal.find('[name="if_not_questionData"]').val(),
            };

            if (data.question) {
                var trStart = '<tr><td style="width: 10%;">';
                var td = '</td><td>';
                var trEnd = '</td></tr>';
                var content = '';
                if (data.note)
                    content += '(<small class="text-muted">' + data.note + '</small>)<br />';

                content = getContentOfQuestion(data, content);

                var idField = '<input type="hidden" name="questionListId[]" value="0" />';
                var action = idField + '<a href="#" class="editQuestion"><i class="fa fa-edit"></i></a>' +
                    ' | <a href="#" class="removeQuestion text-danger"><i class="fa fa-remove"></i></a>';

                var html = trStart + td + content + '</td><td class="text-right" style="width: 10%;">' + action + trEnd;
                clearForm(parentModal);
                parentModal.find('.questionContainer').append(html);
                addIndex(parentModal);

            } else {
                parentModal.find('.help-block').show();
            }
        });

        var parentTr = null;
        $('.modal').on('click', '.editQuestion', function (e) {
            e.preventDefault();
            parentTr = $(this).closest('tr');
            var parentModal = $(this).closest('.modal');
            clearForm(parentModal);
            parentModal.find('#noteData').val(parentTr.find('.data1').val());
            parentModal.find('#questionData').val(parentTr.find('.data2').val());
            parentModal.find('#if_not_questionData').val(parentTr.find('.data3').val());
            parentModal.find('.addQuestionToList').hide();
            parentModal.find('.updateButtons').show();

        });

        $('.modal').on('click', '.updateQuestionToList', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('.help-block').hide();
            var data = {
                note: parentModal.find('[name="noteData"]').val(),
                question: parentModal.find('[name="questionData"]').val(),
                if_not_question: parentModal.find('[name="if_not_questionData"]').val(),
            };

            if (data.question) {
                var content = '';
                if (data.note)
                    content += '(<small class="text-muted">' + data.note + '</small>)<br />';

                content = getContentOfQuestion(data, content);

                clearForm(parentModal);
                parentTr.find('td:nth-child(2)').html(content);

                parentTr = null;
            } else {
                parentModal.find('.help-block').show();
            }
        });

        $('.modal').on('click', '.removeQuestion', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            $(this).closest('tr').slideUp("fast", function() {
                $(this).remove();
                addIndex(parentModal);
            } );

        });

        $('.modal').on('click', '.cancelQuestionUpdate', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            clearForm(parentModal);
            parentTr = null;
        });

        function getContentOfQuestion(data, content) {
            content += data.question;

            if (data.if_not_question) {
                content += '<p style="border-top: 1px solid;">' + data.if_not_question + '</p>';
            }

            content += '<div style="display: none;">' +
                '<input type="hidden" class="data1" name="question_note[]" value="' + data.note + '" />' +
                '<input type="hidden" class="data2" name="question[]" value="' + data.question + '" />' +
                '<input type="hidden" class="data3" name="if_not_question[]" value="' + data.if_not_question + '" />' +
                '</div>';

            return content;
        }

        function clearForm(parentForm) {
            parentForm.find('.add-question-form input').val('');
            parentForm.find('.add-question-form textarea').val('');
            parentForm.find('.updateButtons').hide();
            parentForm.find('.addQuestionToList').show();
            parentForm.find('.addQuestionOnlyToList').show();
        }

        function addIndex(parentForm) {
            var count = 1;
            parentForm.find('table tr').each(function () {
                $(this).find('td:first-child').html(count++);
            });
        }



        // add to list only one question

        $('.modal').on('click', '.addQuestionOnlyToList', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('.help-block').hide();
            var data = {
                question: parentModal.find('[name="questionData"]').val(),
            };

            if (data.question) {
                var trStart = '<tr><td style="width: 10%;">';
                var td = '</td><td>';
                var trEnd = '</td></tr>';
                var content = data.question;

                content += '<div style="display: none;">' +
                    '<input type="hidden" class="data1" name="question[]" value="' + data.question + '" />' +
                    '</div>';

                var idField = '<input type="hidden" name="questionListId[]" value="0" />';
                var action = idField + '<a href="#" class="editQuestionOnly"><i class="fa fa-edit"></i></a>' +
                    ' | <a href="#" class="removeQuestion text-danger"><i class="fa fa-remove"></i></a>';

                var html = trStart + td + content + '</td><td class="text-right" style="width: 10%;">' + action + trEnd;
                clearForm(parentModal);
                parentModal.find('.questionContainer').append(html);
                addIndex(parentModal);

            } else {
                parentModal.find('.help-block').show();
            }
        });

        $('.modal').on('click', '.editQuestionOnly', function (e) {
            e.preventDefault();
            parentTr = $(this).closest('tr');
            var parentModal = $(this).closest('.modal');
            clearForm(parentModal);
            parentModal.find('[name="questionData"]').val(parentTr.find('.data1').val());
            parentModal.find('.addQuestionOnlyToList').hide();
            parentModal.find('.updateButtons').show();

        });

        $('.modal').on('click', '.updateQuestionOnlyToList', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('.help-block').hide();
            var data = {
                question: parentModal.find('[name="questionData"]').val()
            };

            if (data.question) {
                var content = data.question;

                content += '<div style="display: none;">' +
                    '<input type="hidden" class="data1" name="question[]" value="' + data.question + '" />' +
                    '</div>';

                clearForm(parentModal);
                parentTr.find('td:nth-child(2)').html(content);

                parentTr = null;
            } else {
                parentModal.find('.help-block').show();
            }
        });

        // submit form
        $('.modal').on('submit', '#form_add_question', function (e) {
            e.preventDefault();
            var parentModal = $(this).closest('.modal');
            parentModal.find('[type="submit"]').append(' <i class="fa fa-spin fa-spinner"></i>');
            $.post($(this).attr('action'), $(this).serialize(), function(response) {
                parentModal.find('[type="submit"] i.fa.fa-spin').remove();
                parentModal.modal('hide');
                showAlert('Success', response, true);
            }).fail(function (response) {
                showAlert('Error', 'Unsuccessful to update data', false);
            });
        });

        function showAlert(title, message, success) {
            if (success === 'undefined' || success === null || success ==='')
                success = false;

            $.smallBox({
                title : title,
                content : "<i class='fa fa-clock-o'></i> <i>" + message + "</i>",
                color : (success === true) ? "#5a7e5a" : '#953b39',
                iconSmall : "fa fa-" + (success === true ? "check" : 'remove') + " bounce animated",
                timeout : 4000
            });
        }
    });
</script>