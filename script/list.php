<?php
if(!defined('__LIST_PHP__'))
{
   define('__LIST_PHP__',1);

   class Element
   {
	  public $Next;
	  public $Data;
   }

   class My_List
   {
    public $Head;
	  public function __construct()
	  {
	     $this->Head = NULL;
	  }
	  public function Insert($Arg_Data)
	  {
         if (!$this->Head)
         {
       	    $this->Head = new Element;
       	    $this->Head->Data = $Arg_Data;
       	    $this->Head->Next = NULL;
         }
         else
         {
       	    $Temp = &$this->Head;
       	    while ($Temp->Next != NULL)
       	    {
       	    	$Temp = &$Temp->Next;
       	    }
       	    $Temp->Next = new Element;
       	    $Temp->Next->Data = $Arg_Data;
       	    $Temp->Next->Next = NULL;
         }
	  }
	  public function At($Arg_Position)
	  {
	  	 if (!$this->Head) return 0;
         if ($Arg_Position == 0) return $this->Head->Data;
         $Temp = &$this->Head;
         $i = 0;
         while ($i < $Arg_Position)
         {
            if ($Temp->Next == NULL) return 0;
            else 
            {
            	$i = $i + 1;
                $Temp = &$Temp->Next;
            }
         }
         return $Temp->Data;
	  }
   }
}
?>