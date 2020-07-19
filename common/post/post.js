class Post{
    constructor(query){
        this.query=query;
        this.first = true;
        this.offset=0;
        this.body = document.getElementById('content');
        this.send_str = '';
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
        this.send_str='query='+this.query + " ORDER BY post_index DESC limit "+this.offset+", 5;";

        var obj = this;
        this.xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                obj.body.querySelector('#page_loader').outerHTML='';
                if(this.responseText==''){
                    obj.body.innerHTML += "<div>End of posts</div>";
                    obj.first = false;
                }else{
                    obj.body.innerHTML+= this.responseText;
                    obj.first = true;
                }
            }
            if(this.readyState == 1){
                obj.body.innerHTML += "<div class='page_loader' id='page_loader'></div>";
                obj.first = false;
            }
        };
        this.xhttp.open('POST', '/common/post/post_ajax.php',true);
        this.xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.xhttp.send(this.send_str);
        
        this.offset+=5;
    }
}

function like(element){
    var parent = element.parentElement.parentElement.parentElement.parentElement;
    var post_index = parent.querySelector('.post_index').value;
    var send = "like=true&post_index=".concat(post_index);
    response(send);
    element.outerHTML = " <button class='button_con  but_1_2' onclick='unlike(this)'><i class='fas fa-thumbs-up' aria-hidden='true'></i><b> liked</b></button>";
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
    xhttp.open('POST', '/common/post_event_ajax.php',true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(send_str);
}