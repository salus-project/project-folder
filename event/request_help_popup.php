<div  class="form_box">
    <div class=dis_container>
        <label class="head_label"> District (current) </label><br>
        <select name="district" class="dis_selection">
            <option value='Ampara'>Ampara</option>
            <option value='Anurashapura'>Anurashapura</option>
            <option value='Badulla'>Badulla</option>
            <option value='Batticaloa'>Batticaloa</option>
            <option value='Colombo'>Colombo</option>
            <option value='Galle'>Galle</option>
            <option value='Gampha'>Gampha</option>
            <option value='Hambatota'>Hambantota</option>
            <option value='Jaffna'>Jaffna</option>
            <option value='Kaltura'>Kaltura</option>
            <option value='Kandy'>Kandy</option>
            <option value='Kegalle'>Kegalle</option>
            <option value='Kilinochchi'>Kilinochchi</option>
            <option value='Kurunegala'>Kurunegala</option>
            <option value='Mannar'>Mannar</option>
            <option value='Matale'>Matale</option>
            <option value='Mathara'>Mathara</option>
            <option value='Moneragala'>Moneragala</option>
            <option value='Mullaitivu'></option>
            <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
            <option value='Polonnaruwa'>Polonnaruwa</option>
            <option value='Puttalam'>Puttalam</option>
            <option value='Ratnapura'>Ratnapura</option>
            <option value='Tricomalee'>Tricomalee</option>
            <option value='Vavuniya'>Vavuniya</option>
        </select>
    </div>


    <div class=head_label_container><label class="head_label">Help Type </label></div>
    <table>
        <tr>
            <td class=check_menu>
                <input type="checkbox" name="type[]" value="money" onclick="OnChangeCheckbox (this,'money_des_con')" id ="money"> Money<br>
            </td>
            <td class=des_area>
                <div id=money_des_con style="display:none">
                    <label class="label">Enter amount you expect</label><br>
                    <textarea cols="30" rows="4"  class="input_box" name="money_description" id="money_des"></textarea><br>
                </div>
            </td>
        </tr>
        <tr>
            <td class=check_menu>
                <input type="checkbox" name="type[]" value="good" onclick="OnChangeCheckbox (this,'goods_des_con')" id ="good">Things<br>
            </td>
            <td class=des_area>
                <div id=goods_des_con style="display:none">
                    <label class="label">Things you expect</label><br>
                    <textarea cols="30" rows="4"  class="input_box" name="good_description" id="good_des"></textarea><br>
                </div>
            </td>
        </tr>
    </table>
    <div class=buttons>
        <input name="submit_button" type="submit"  value="Request"  class="submit_button" id=req_submit_btn onclick="submit_request()">
        <button id=close_request_popup class=submit_button>Cancel</button>
    </div>
</div>

