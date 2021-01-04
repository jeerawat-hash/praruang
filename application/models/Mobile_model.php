<?php 

class Mobile_model extends CI_Model
{ 


  public function getDataCustomerByCar($CarCode)
  {

     $this->mssql = $this->load->database("mssql",true);

      return $this->mssql->query("SELECT b.CustomerName,'ตึก '+SUBSTRING(b.Room,2,2) + ' ' +'ห้อง '+SUBSTRING(b.Room,5,2) as AddressLocal,a.CARCODE,a.CARBRAND,a.CARCOLOR,a.CARTYPE,a.COUNTRY,a.CONTACT 
  FROM [Sakorn_Bangboo].[dbo].[CustomerCarInfo] a 
  join Sakorn_Bangboo.dbo.Customer b on a.CUST = b.CustomerID 
  where a.CARCODE like '".$CarCode."%'  ")->result();


  }

  public function CustomerAuth($CustomerID)
  {

     $this->mssql = $this->load->database("mssql",true);


     return $this->mssql->query(" select CustomerID,TitleName+' '+CustomerName+' '+NoHome as CustomerINFO,ProjectCode from Sakorn_Bangboo.dbo.Customer where CustomerID = '".$CustomerID."'  ")->result();


  }
  public function getDataBlanace($CUST)
  {

        $this->mssql = $this->load->database("mssql",true);
/*
        return $this->mssql->query(" 
 select CustomerID,CustomerName,ISNULL( convert(varchar(20) ,sum(a.AMOUNT)) ,'0') as AmountTotal from [Sakorn_Bangboo].[dbo].[CustomerAmount_LOG] a
 right outer join Sakorn_Bangboo.dbo.Customer b on a.CUST = b.CustomerID
   where b.CustomerID = '".$CUST."'  and a.ProjectCode = '".$ProjectCode."'
   group by CustomerID,CustomerName ")->result();
*/
         return $this->mssql->query(" select CustomerID,CustomerName,(select ISNULL( convert(varchar(20) ,sum(AMOUNT)) ,'0') as AmountTotal from Sakorn_Bangboo.dbo.Customer a
   join Sakorn_Bangboo.dbo.CustomerAmount_LOG b on a.CustomerID = b.CUST
    where a.CustomerID = '".$CUST."'   ) as AmountTotal 
  from Sakorn_Bangboo.dbo.Customer a  where a.CustomerID = '".$CUST."'  ")->result();


  }

  public function getDataBlanaceDetail($CUST)
  {

        $this->mssql = $this->load->database("mssql",true);
        /*
        return $this->mssql->query("select CustomerID,CustomerName,a.AMOUNT as AmountTotal,c.Description,a.DATE from [Sakorn_Bangboo].[dbo].[CustomerAmount_LOG] a
 right outer join Sakorn_Bangboo.dbo.Customer b on a.CUST = b.CustomerID  
 join [Sakorn_Bangboo].[dbo].[CustomerAmount_CodeType] c on a.CODE = c.CODE
 where b.CustomerID = '".$CUST."' and a.ProjectCode = '".$ProjectCode."' order by DATE asc ")->result();
  */
    return $this->mssql->query("  select CustomerID,CustomerName,a.AMOUNT as AmountTotal, a.infocode as Description,a.DATE from [Sakorn_Bangboo].[dbo].[CustomerAmount_LOG] a
 right outer join Sakorn_Bangboo.dbo.Customer b on a.CUST = b.CustomerID   
 where b.CustomerID = '".$CUST."'  order by DATE asc  ")->result();


  }

 

  public function Authentication($Secrect)
  {
     $this->mssql = $this->load->database("mssql",true);
     
     $checkKey = 1;

     if ($Secrect == "Sakorn@") {
       $checkKey = 0;
     }

     if ($checkKey == 0) {
        return 1;
     }else{
        return 0;
     }


  }
 
  public function ClearDataCustomerName()
  {

     $this->mssql = $this->load->database("mssql",true);
      $checkCustomer = $this->mssql->query(" delete from [Sakorn_Bangboo].[dbo].[Customer]  ");


  }
  public function SyncDataCustomerName($CUST,$TitleName,$CustomerName)
  {

     $this->mssql = $this->load->database("mssql",true);
 
      $this->mssql->query(" 

          INSERT INTO [Sakorn_Bangboo].[dbo].[Customer]
           ([CustomerID]
           ,[TitleName]
           ,[CustomerName]
           ,[NoHome]
           ,[Room])
     VALUES
           ('".$CUST."'
           ,'".$TitleName."'
           ,'".$CustomerName."'
           ,'".$CUST."'
           ,'".$CUST."') "); 
 

  }


  public function insertDataCarInfo($CUST,$CARCODE,$COUNTRY,$CARTYPE,$CARBRAND,$CARCOLOR,$CONTACT)
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query(" INSERT INTO [Sakorn_Bangboo].[dbo].[CustomerCarInfo]
           ([CUST]
           ,[CARCODE]
           ,[COUNTRY]
           ,[CARTYPE]
           ,[CARBRAND]
           ,[CARCOLOR]
           ,[CONTACT])
     VALUES
           ('".$CUST."'
           ,'".$CARCODE."'
           ,'".$COUNTRY."'
           ,'".$CARTYPE."'
           ,'".$CARBRAND."'
           ,'".$CARCOLOR."'
           ,'".$CONTACT."') ");


  }

  public function clearDataCarInfo()
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query(" delete from [Sakorn_Bangboo].[dbo].[CustomerCarInfo]  ");
 
  }

 
  public function insertDataServicesCost($CUST,$DATE,$CODE,$AMOUNT,$DETAIL)
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query("INSERT INTO [Sakorn_Bangboo].[dbo].[CustomerAmount_LOG]
           ([CUST]
           ,[DATE]
           ,[CODE]
           ,[AMOUNT]
           ,[InfoCode])
     VALUES
           ('".$CUST."'
           ,'".$DATE."'
           ,'".$CODE."'
           ,'".$AMOUNT."'
           ,'".$DETAIL."') ");


  }

  public function clearDataServicesCost()
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query(" delete from [Sakorn_Bangboo].[dbo].[CustomerAmount_LOG]  ");
 
  }

    public function insertDataReceiveCost($CUST,$RECEIPT,$CODE,$AMOUNT,$DETAIL,$PAYTYPE)
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query(" INSERT INTO [Sakorn_Bangboo].[dbo].[CustomerPay_LOG]
           ([CUST]
           ,[RECEIPT]
           ,[PAYTYPE_ID]
           ,[DATE]
           ,[CODE]
           ,[AMOUNT]
           ,[InfoCode])
     VALUES
           ('".$CUST."'
           ,'".$RECEIPT."'
           ,'".$PAYTYPE."'
           ,'".date("Y-m-d")."'
           ,'".$CODE."'
           ,'".$AMOUNT."'
           ,'".$DETAIL."') ");


  }

  public function clearDataReceiveCost()
  {

     $this->mssql = $this->load->database("mssql",true);

     $this->mssql->query(" delete from [Sakorn_Bangboo].[dbo].[CustomerPay_LOG]  ");
 
  }

  public function ReportCustomerTotal()
  {

     $this->mssql = $this->load->database("mssql",true);

     return $this->mssql->query("  select sum(list) as AMOUNT from (
 select isnull(sum(a.AMOUNT),0) as List,a.InfoCode as Description from Sakorn_Bangboo.dbo.CustomerAmount_LOG a 
 group by a.Code,a.InfoCode  
  )a  ")->result();
 
  }
  public function ReportCustomerTotalDetail()
  {

     $this->mssql = $this->load->database("mssql",true);

     return $this->mssql->query(" 
  select isnull(sum(a.AMOUNT),0) as List,a.InfoCode as Description from Sakorn_Bangboo.dbo.CustomerAmount_LOG a 
 group by a.Code,a.InfoCode order by List Desc")->result();
 
  }
  public function ReportCustomerReceive()
  {

     $this->mssql = $this->load->database("mssql",true);

     return $this->mssql->query(" 
 select isnull(sum(a.AMOUNT),0) as List,(case when a.InfoCode = '' then 'อื่นๆ' else a.InfoCode end) as  Description 
 from Sakorn_Bangboo.dbo.CustomerPay_LOG a 
  group by a.Code,a.InfoCode  ")->result();
 
  }

  public function ReportCustomerReceiveDetail()
  {

     $this->mssql = $this->load->database("mssql",true);

     return $this->mssql->query("  select Description,Count(RECEIPT) as Receipt,Sum(RECEIPTList) as List,sum(Amount) as Amount from (
 select RECEIPT,b.Description,count(RECEIPT) as RECEIPTList,sum(a.Amount) as Amount from Sakorn_Bangboo.dbo.CustomerPay_LOG a 
 join Sakorn_Bangboo.dbo.CustomerPay_Type b on a.PAYTYPE_ID = b.ID  group by RECEIPT,b.Description
 )a group by Description ")->result();
 
  }


  public function createDataFromXlsx($file)
  {

      $this->load->library("SimpleXLSX");
      $this->SimpleXLSX = new SimpleXLSX(); 

      if ( $xlsx = $this->SimpleXLSX->parse('./upload/temp/'.$file)) {
 
        $header_values = $rows = [];

        foreach ( $xlsx->rows() as $k => $r ) {
          if ( $k === 0 ) {
            $header_values = $r;
            continue;
          }
          $rows[] = array_combine( $header_values, $r );
        }


        return $rows;
      

      }
 

  }
 







 








}

 ?>