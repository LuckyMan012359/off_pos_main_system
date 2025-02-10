$(document).ready(function () {
    let onscreen_keyboard_status = $('#onscreen_keyboard_status').val();
    if(onscreen_keyboard_status == 'Enable'){
        $('.easy-get').on('click', () => {
            let inputVal = $('.easy-put').val();
            show_easy_numpad(inputVal);
        });


        function show_easy_numpad(inputVal) {
            let inputReady = inputVal.replace("%", "");
            if(inputReady > 0){
                inputReady = inputVal;
            }else{
                inputReady = '';
            }
            let easy_numpad = `
                <div class="easy-numpad-frame" id="easy-numpad-frame">
                    <div class="easy-numpad-container">
                        <div class="easy-numpad-output-container">
                            <p class="easy-numpad-output" id="easy-numpad-output">${inputReady}</p>
                        </div>
                        <div class="easy-numpad-number-container">
                            <table>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">7</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">8</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">9</a></td>
                                    <td><a href="javascript:void(0)" class="del" id="del">Del</a></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">4</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">5</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">6</a></td>
                                    <td><a href="javascript:void(0)" class="clear" id="clear">Clear</a></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">1</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">2</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">3</a></td>
                                    <td><a href="javascript:void(0)" class="cancel-n" id="cancel">Cancel</a></td>
                                </tr>
                                <tr>
                                    <td class="numberTrigger"><a href="javascript:void(0)">0</a></td>
                                    <td class="numberTrigger"><a href="javascript:void(0)">%</a></td>
                                    <td class="numberTrigger"><a href="javascript:void(0)">.</a></td>
                                    <td><a href="javascript:void(0)" class="done" id="done">Done</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(easy_numpad);
        }
        $(document).on('click', '.numberTrigger', function(){
            easynum();
        });
        function easynum() {
            navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
            if (navigator.vibrate) {
                navigator.vibrate(60);
            }
            let easy_num_button = $(event.target);
            let easy_num_value = easy_num_button.text();
            $('#easy-numpad-output').append(easy_num_value);
        }
        $(document).on('click', '#done', function(){
            easy_numpad_done();
        });
        function easy_numpad_done() {
            let easy_numpad_output_val = $('#easy-numpad-output').text();
            $('.easy-put').val(easy_numpad_output_val);
            easy_numpad_close();
        }
        $(document).on('click', '#cancel', function(){
            easy_numpad_cancel();
        });
        function easy_numpad_cancel() {
            $('#easy-numpad-frame').remove();
            $('.pos__modal__overlay').css('display', 'block');
        }
        $(document).on('click', '#clear', function(){
            easy_numpad_clear();
        });
        function easy_numpad_clear() {
            $('#easy-numpad-output').text("");
        }
        $(document).on('click', '#del', function(){
            easy_numpad_del();
        });
        function easy_numpad_del() {
            let easy_numpad_output_val = $('#easy-numpad-output').text();
            let easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
            $('#easy-numpad-output').text(easy_numpad_output_val_deleted);
        }
        function easy_numpad_close() {
            $('#easy-numpad-frame').remove();
        }
    }
});







