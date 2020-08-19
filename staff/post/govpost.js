function create_post(arr,user_nic=''){
    var html =  "<div class='posts'>"+
                    "<input type='hidden' class='post_index' value='"+arr['post_index']+"'>"+
                    "<div>"+
                        "<div class='post_title'>"+
                            "<div class='profile'>"+
                                "<div class='author post_a'>"+
                                    "<b>"+arr['heading']+"</b>";
                                    if(!arr['event']==''){
                                        html+= " <i class='fa fa-toggle-right'></i> for <a class='post_a' href='"+arr['event']+"'>"+arr['event_name']+"</a>";
                                    }
                        if(user_nic!==''){
                            var stt="<div class='view_post_div'>"+
                                "<a href='/common/post/view_post.php?post_index="+arr['post_index']+"' class='vie_post_a'><button class='view_post_but'>View</button></a>"+
                            "</div>";
                        }else{
                            var stt="";
                        }
                        html+= "</div>"+
                                "<div class='post_date'> Date: "+arr['date']+"</div>"+
                            "</div>"+stt+
                        "</div>"+
                    "</div>"+
                    "<div><div class='post_content'>" +arr['content'] + "</div></div>";
                    if(!arr['img']==''){
                        html+= "<div class=post_image_container><img class=post_image src='"+arr['img']+"'/></div>";
                    }
                    var likes = arr['likes'].split(' ');
                    if(user_nic!==''){
                        html+=  "<div class='like_bar'>"+
                                    "<div class='likes'>"+
                                        "<span class='like_count'>"+
                                            likes.length + " likes"+
                                        "</span>"+
                                    "</div>"+
                                    "<div class='buttons_container'>"+
                                        "<div class='button_div'>"+
                                            "<button class='button_con  but_1_2' ";
                                                if(likes.includes(user_nic)){
                                                    html+= "onclick='unlike(this)' style='color:#4c5fd7'><i class='fas fa-thumbs-up' style='color:#4c5fd7'></i><b> liked</b>";
                                                }else{
                                                    html+= "onclick='like(this)'><i class='far fa-thumbs-up'></i> <b>like</b>";
                                                }
                            html+=                "</button>"+
                                        "</div>"+
                                        "<div class='button_div'>"+
                                            "<button class='button_con  but_1_2' onclick='show_comment(this)'>"+
                                                "<i class='far fa-comment-alt'></i><b> "+
                                                    +arr['comments'] + " comments</b>"+
                                            "</button>"+
                                        "</div>"+
                                        "<div class='button_div'>"+
                                            "<button class='button_con  but_3'>"+
                                                "<i class='fa fa-share'></i><b> share</b>"+
                                            "</button>"+
                                        "</div>"+
                                        
                                    "</div>"+
                                "</div>"+
                                "<div class='comment_box_container'>"+
                                    "<div class='comment_box'></div>"+
                                    "<div class='new_comment'>"+
                                        "<div class='comment_div'>"+
                                            "<input type='text' class='comment_input' placeholder='Enter your comment..'>"+
                                        "</div>"+
                                        "<div class='tooltip send_icon' onclick='comment(this)'>"+
                                            "<span class='send_btn'><i class='fa fa-send'></i></span>"+
                                            "<span class='tooltiptext'>SEND</span>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";
                    }
                    html+="</div>";
    return html;
}


class Post{
    constructor(user_nic){
        this.user_nic=user_nic;
        this.first = true;
        this.offset=0;
        this.body = document.getElementById('content');
        this.send_str = '';
        this.ajax_response;
        this.xhttp = new XMLHttpRequest();
        window.addEventListener("scroll", (e) => {
            this.loadpage();
        });
    }
    loadpage(){
        if (document.body.scrollTop > document.body.scrollHeight - window.innerHeight -100 || document.documentElement.scrollTop > document.body.scrollHeight - window.innerHeight -100) {
            if(this.first){
                this.get_post();
            }
        }
    }
    get_post(){
        this.send_str='offset='+this.offset;

        var obj = this;
        this.xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                obj.body.querySelector('#page_loader').outerHTML='';
                if(this.responseText=='[]'){
                    obj.body.innerHTML += "<div>End of posts</div>";
                    obj.first = false;
                }else{
                    obj.ajax_response=JSON.parse(this.responseText);
                    obj.convert_response();
                    obj.first = true;
                }
            }
            if(this.readyState == 1){
                obj.body.innerHTML += "<div class='page_loader' id='page_loader'></div>";
                obj.first = false;
            }
        };
        this.xhttp.open('POST', '/staff/post/get_post_ajax.php',true);
        this.xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.xhttp.send(this.send_str);
        
        this.offset+=5;
    }
    convert_response(){
        var html='';
        for (var key in this.ajax_response){
            html += create_post(this.ajax_response[key], this.user_nic);
        }
        this.body.innerHTML+= html;
    }
}

function like(element){
    var parent = element.parentElement.parentElement.parentElement.parentElement;
    var post_index = parent.querySelector('.post_index').value;
    var send = "like=true&post_index=".concat(post_index);
    response(send);
    element.outerHTML = " <button class='button_con  but_1_2' style='color:#4c5fd7'><i class='fas fa-thumbs-up' style='color:#4c5fd7' aria-hidden='true'></i><b> liked</b></button>";
}
function unlike(element){
    var parent = element.parentElement.parentElement.parentElement.parentElement;
    var post_index = parent.querySelector('.post_index').value;
    var send = "unlike=true&post_index=".concat(post_index);
    response(send);
    element.outerHTML = " <button class='button_con but_1_2' onclick='like(this)'><i class='far fa-thumbs-up' aria-hidden='true'></i><b> like</b></button>";
}
function show_comment(element){
    var cmt_btn = element.parentElement.parentElement.parentElement.parentElement.querySelector('.comment_box_container');
    cmt_btn.classList.toggle('comment_box_active');
    var post_index = cmt_btn.parentElement.querySelector('.post_index').value;
    var send = "view_cmt=true&post_index=".concat(post_index);
    response(send,cmt_btn.querySelector('.comment_box'));
}
function comment(element){
    var comment = element.parentElement.querySelector('.comment_input').value;
    if(comment!==''){
        var parent = element.parentElement.parentElement.parentElement;
        var post_index = parent.querySelector('.post_index').value;
        send = "comment=true&post_index=".concat(post_index,"&content=",comment);
        response(send);
        send = "view_cmt=true&post_index=".concat(post_index);
        response(send,element.parentElement.previousElementSibling);
        element.parentElement.firstElementChild.value = '';
    }
}

function response(send_str,element){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if(typeof element !== 'undefined'){
                element.innerHTML =  this.responseText;
            }
        }
    };
    xhttp.open('POST', '/common/post/post_event_ajax.php',true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(send_str);
}