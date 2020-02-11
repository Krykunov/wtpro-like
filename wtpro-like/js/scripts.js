import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".button-like").on("click", this.ourClickDisp.bind(this))
    }

    //methods
    ourClickDisp(e) {

        let currentButtonLike = $(e.target).closest(".likes-block");

        if (currentButtonLike.find(".button-like").attr('data-exists') === 'yes'){
            this.deleteLike(currentButtonLike)
        } else {
            this.createLike(currentButtonLike)
        }
    }

    createLike(currentButtonLike) {

       $.ajax({
           beforeSend: (xhr) => {
               xhr.setRequestHeader('X-WP-Nonce', websiteData.nonce);
           },
           url: websiteData.root_url + '/wp-json/wtpro/v1/manageLikes',
           type: 'POST',
           data: {'thispostID': currentButtonLike.find(".button-like").data('postid')},
           success: (response) => {
               currentButtonLike.find(".button-like").attr('data-exists', 'yes');
               let likeCount = parseInt(currentButtonLike.find(".likes-count").html(), 10);
               likeCount++;
               currentButtonLike.find(".button-like").html("Liked");
               currentButtonLike.find(".likes-count").html(likeCount);
               currentButtonLike.find(".button-like").attr("data-like", response);
               console.log(response);
           },
           error: (response) => {
               console.log(response);
           }
       });
    }

    deleteLike(currentButtonLike) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', websiteData.nonce);
            },
            url: websiteData.root_url + '/wp-json/wtpro/v1/manageLikes',
            data: {'like': currentButtonLike.find(".button-like").attr('data-like')},
            type: 'DELETE',
            success: (response) => {
                currentButtonLike.find(".button-like").attr('data-exists', 'no');
                let likeCount = parseInt(currentButtonLike.find(".likes-count").html(), 10);
                likeCount--;
                currentButtonLike.find(".likes-count").html(likeCount);
                currentButtonLike.find(".button-like").html("Like");
                currentButtonLike.find(".button-like").attr("data-like", '');
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

}

var like = new Like();
