$(function(){

    $("#SendSyncServicesCost").on("click",function(){

        $("#DataSyncServicesCostModal").modal("show");
        $("#DataSyncServicesCostModal").find("#PreloadSendData").hide();
        $("#DataSyncServicesCostModal").find("#SendData").show();
        $('#ServicesCostfile').val('');


    });


    $("#DataSyncServicesCostModal").find("#SendData").on("click",function(){
 

            ////// ไฟล์ 
            var Slip_file = $('#ServicesCostfile').prop('files')[0]; 
            ////// ไฟล์
            var data = new FormData();      
            ////// เพิ่มข้อมูลเข้า          
            data.append('ServicesCost', Slip_file); 
            //data.append('Telephone', Telephone );
            ////// เพิ่มข้อมูลเข้า array           
 
 
        $("#DataSyncServicesCostModal").find("#SendData").hide();
        $("#DataSyncServicesCostModal").find("#PreloadSendData").show();


		setTimeout(function(){ 


            $.ajax({
                url: "https://praruang.sakorncable.com/index.php/management/createDataServicesCostFromXlsx",
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){

                    console.log(data);
                
                    if (data == 1) {


                    //alert("บันทึกข้อมูลสำเร็จ....");
                    swal("สำเร็จ","บันทึกข้อมูลสำเร็จ", "success");
                    
                    $("#DataSyncServicesCostModal").modal("hide");

                    $("#DataSyncServicesCostModal").find("#SendData").show();
                    $("#DataSyncServicesCostModal").find("#PreloadSendData").hide();

                    }else
                    if (data == 2){

                        swal("ผิดพลาด","ผิดพลาดกรุณาลองใหม่ภายหลัง", "error");
                        //alert("ผิดพลาดกรุณาลองใหม่ภายหลัง...");
                        $("#DataSyncServicesCostModal").find("#SendData").show();
                        $("#DataSyncServicesCostModal").find("#PreloadSendData").hide();

                    } 
                    
                      
                },
                error : function(){

                        swal("ผิดพลาด","ผิดพลาดกรุณาลองใหม่ภายหลัง", "error");
                        //alert("404 Not Found");
                        $("#DataSyncServicesCostModal").find("#SendData").show();
                        $("#DataSyncServicesCostModal").find("#PreloadSendData").hide();

                }
                });

  
    

		}, 2000);


 

    });

























});