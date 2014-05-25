;(function($){
    
     var defaults={
        
        tablename : "tree",
                        
        fields    :  ["id","parentid","title"],
    
        lang      : "ar",
        theme     : "blue",
        treetype : "hierarchical",
        excludenodes   : [],
        startfrom : 0
        
        
        
                };
                
                 
                
    
     function Setuptree(element,options)
     {
       this.config=$.extend({},defaults,options);
       this.element=element; //div or table
      // this.treeLevel=1;
       this.setupLanguage(); //english or arabic
       this.nodetype=0;
       this.setupTheme();
       $self=this;
                   /* this.element.on("click","li",function(){
                                   
                                      
                                 
                    });*/
                    $.each(this.config,function(key,val){
                        
                        
                         if(typeof val=== "function"){
                            $self.element.on(key + '.dynamictree',function(){
                                val($self.element);
                            });
                        }
                        
                    });
                    this.element.on("click","a",function(){
                            
                            
                         
                         var $parentli=$(this).parent("li");
                          
                         $($self.element).find('a').css({"background" : "","color": "#000"}); 
                         $(this).css({"background" : $self.backgroundc,"color": "#000"});
                        
                         if($parentli.data("leafnode")>0) 
                         {
                           if($parentli.children("ul").is(":visible"))  
                           {
                                $parentli.children("ul").hide(0, function () { $(this).remove();});
                           }
                           else
                           {
                                
                           $self.config.startfrom=$parentli.attr("id");
                           $self.generate($parentli);
                           }
                         }  
                          
                             
                         
                            event.preventDefault();       
                                      
                                
                      });
               
       
       
                   
                
                
                    
                             
                   
       
                    
             
          
       
       
       this.generate(this.element);
     }
     
     Setuptree.prototype.setupLanguage=function(){
     
      if(this.config.treetype=='hierarchical')
      { 
        
            if(this.config.lang=='ar')
           {
            this.floatt="right";
          // this.floattclass="arfloat"; 
           this.direction='ardirection';
           this.padding='0px';
           this.imageclass='';
           this.marginposition='';
           
           }
           else
           {
            this.floatt="left";
          // this.floattclass="enfloat";  
           this.direction='endirection';
           this.padding='0px';
           this.imageclass='dyanamictree';
           this.marginposition='margin-left';
           } 
           
         this.additionalpadding='0px';   
      }
      else
      {
           if(this.config.lang=='ar')
           {
           this.floattclass="arfloat"; 
           this.direction='ardirection'; 
           this.floatt="right"; 
       
           this.imageclass='dyanamictree_ar';
           this.marginposition='margin-right';
           this.padding='5px';
           }
           else
           {
           this.floatt="left"; 
           this.floattclass="enfloat"; 
           this.direction='endirection'; 
           
           this.padding='5px';
           this.imageclass='dyanamictree';
           this.marginposition='margin-left';
           
           } 
           this.additionalpadding='25px';
       }  
        
     };
     
     Setuptree.prototype.setupTheme=function(){
        if(this.config.treetype=='hierarchical')
        {
          this.element.addClass("hierarchy").css("float",this.floatt);
          
           switch(this.config.theme)
          {
            case "yellow":
            this.backgroundc='#FFE090';
            break;
            case "blue":
            default:
            this.backgroundc='#c8e4f8';
            
          }
         
          
        }
        else
        {
           switch(this.config.theme)
          {
            case "yellow":
            this.closedfolderclass='dyanamictree-folder';
            this.endnode='dyanamictree-folder_lastsub';
            this.backgroundc='#FFE090';
             break;
            case "blue":
            default:
            this.closedfolderclass='dyanamictree-arrow_close';
            this.endnode='dyanamictree-folder_lastsub';
            this.backgroundc='#c8e4f8';
            
          }
            
            this.element.addClass("dynamictree").css("float",this.floatt);
        }
          
          
          
          
          
     }
     
     
     Setuptree.prototype.generate=function(elemm){
        
                
               
                
                
                $.ajax({
                    type : "GET",
                    url : "parent_tree.php",
                    
                    headers : {
                            "X-REQUESTED-BY" : "Dynamic-Tree2"
                    },
                    contentType : "application/json;charset=utf-8",
                    data : 'param='+JSON.stringify({tablename : $self.config.tablename,tablefields : $self.config.fields,startfrom : $self.config.startfrom,excludenodes : $self.config.excludenodes}),
                   dataType : "json",
                    
                    beforeSend : function(){
                       //$(this).html("Loading..");
                    }
                    
                    
                }).done(function(data){
                   //success
                        //$(this).html('');
                        
                        $(this).css('direction',$self.direction); // direction
                        var padding='padding-'+$self.floatt;
                    
                       var $ul=$("<ul/>").css(padding,$self.additionalpadding).appendTo(elemm);
                       
                      $.each(data, function(index, value) {
                          
                          var json_result=data[index];
                          
                          var result = [];

                                for(var i in json_result)
                                result.push([i, json_result [i]]); 
                    
                                         //  console.log(result)/// remove later
                        
                          
                          
                           
                           
                           
                           var rowCount,resultlength=result.length-1;
                            if(result[resultlength][1]>0)//last array will be leaf node
                           {
                                $self.nodetype=$self.closedfolderclass; // folder have sub folder
                                rowCount=result[resultlength][1];
                           }
                           else
                           {
                                $self.nodetype=$self.endnode;  // no more node
                                rowCount=0;
                           }
                          
                           
                            
                             var $li=$("<li/>",{
                                   "id" : result[0][1],
                                   "data-leafnode" : rowCount,
                                  }).addClass($self.floattclass).appendTo($ul);
                                
                             $("<div/>",{
                                "class" : $self.imageclass// css sprite image according to language
                                
                             }).addClass($self.nodetype+' '+$self.floattclass).appendTo($li);
                           
                              $('<a/>',{
                                href : "sub_node.php",
                                text : result[2][1]
                               // id    : result[0][1],
                                
                            
                                                        
                                }).addClass($self.floattclass).appendTo($li).show(500);
                             
                           
                         
                          
                        
                          
                          
                      });
                                                
                       
                         
                    
                }).fail(function(m){
                    
                    $(this).html("Sorry Something Went Wrong!");
                    
                });
       
       
     };  
     

       
    
     
       Setuptree.prototype.subTree=function(elem){
            
            console.log(elem)
            
            var $ul=$("<ul/>").appendTo(elem);
            
            $li2=$("<li/>").appendTo($ul);
            
                                $('<a/>',{
                                href : "sub_node.php",
                                 text : "subnode 2"
                               // id    : result[0][1],
                                
                            
                                                        
                                }).appendTo($li2);
                                               
            
            
        };
         
        
        $.fn.dynamictree=function(options){
            
            var element=this;            
            new Setuptree(element,options)
            
        
        };
        
        
    
})(jQuery);