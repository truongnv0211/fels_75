$(function(){
  $('.ajax-follow').on({
    click: function(e){
      e.preventDefault();
      var $href = $(this).attr('href');
      $.ajax({
        url: $href,
        method: 'post',
        dataType: 'json',
        cache: false,
        success: function(response) {
          var $link = $('#follow-id-' + response.followee_id);
          var $unfollow_href = '/user/unfollow/' + response.followee_id;
          var $follow_href = '/user/follow/' + response.followee_id;
          var a_href = $link.attr('href');
          if (a_href === $follow_href) {
            $link.attr('href', $unfollow_href);
            $link.html("Unfollow");
          }
          else {
            $link.attr('href', $follow_href);
            $link.html("Follow");
          }
        }
      });
    }
  });
});
