function setLike(mark,id_user){
	//alert(mark+" "+id_user);
	$.ajax({
	  type: "POST",
	  url: '/basic/web/index.php?r=site%2Flike',
	  data: { mark: mark, id_user: id_user }
	}).done(function( data ) {
	   $('#mark').html('mark = '+data)
	});
	

	
	
	
//    alert(id_blog);
   // var id_button = "#likeCount" + id_blog;
   //$.post('/SiteController/setlike/idblog/'+id_blog, function (data){
//       alert(id_button);
 //       $(id_button).html(data.counn[0].coun);
  //  },'json');
}
//function setLikeBlog(id_blog){
//    $.post('/admin/index/setlikeblog', function (data){
//        $('#ajaxBlock').html(id_blog);
//    });
//}