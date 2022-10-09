function changeProdStatus(status, postId) {
  var $ = jQuery;
  $.ajax({
    type: "post",
    dataType: "json",
    url: pd_ajax_object.ajax_url,
    data: {
      action: "my_pd_status_ajax",
      postId: postId,
      status: status,
      nounce: pd_ajax_object.nounce,
    },
    success: function (res) {
      if (1 == res) {
        if (1 == status) {
          var button =
            '<button class="btn btn-danger" onclick="changeProdStatus(0,' +
            postId +
            ')" type="button">Disable Product</button>';
        } else {
          var button =
            '<button class="btn btn-success" onclick="changeProdStatus(1,' +
            postId +
            ')" type="button">Active Product</button>';
        }

        $("#post-" + postId)
          .find(".column-pd_action")
          .html(button);
        alert("Product's status has been changed !");
      } else {
        alert("Server Error.");
      }
    },
  });
}
