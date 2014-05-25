;(function($){
    
     var defaults={
        
        tablename : "tree",
                        
        fields    :  ["id","parentid","title"],
    
        lang      : "ar",
        theme     : "blue",
        treetype : "hierarchical",
        //excludenodes   : [2,3,4],
        startfrom : 0
        
        
        
                };
                
                 
                
    
     function Setuptree(element,options)
     {
       this.config=$.extend({},defaults,options);
       this.element=element; //div or table
       this.treeLevel=1;
       this.setupLanguage(); //english or arabic
       this.nodetype=0;
       this.setupTheme();
       $self=this;
                   /* this.element.on("click","li",function(){
                                   
                                      
                                 
                    });*/
        this.element.on("click","li",function () {
                    
                    $self.subTree(this);
                    event.preventDefault();
       });
                    
             
          
       
       
       this.generate();
     }
     
     Setuptree.prototype.setupLanguage=function(){
     
        
       if(this.config.lang=='ar')
       {
        
       this.floatt="right"; 
       this.direction='rtl';
       this.padding='0px 10px 0px 0px';
       this.imageclass='dyanamictree_ar';
       this.marginposition='margin-right';
       }
       else
       {
       this.floatt="left";  
       this.direction='ltr';
       this.padding='0px 0px 0px 10px';
       this.imageclass='dyanamictree';
       this.marginposition='margin-left';
       }   
        
     };
     
     Setuptree.prototype.setupTheme=function(){
        if(this.config.treetype=='hierarchical')
        {
          this.element.addClass("hierarchy").css("float",this.floatt);
        }
        else
        {
           switch(this.config.theme)
          {
            case "yellow":
            this.closedfolderclass='dyanamictree-folder';
            this.endnode='dyanamictree-folder_lastsub';
            break;
            case "blue":
            default:
            this.closedfolderclass='dyanamictree-arrow_close';
            this.endnode='dyanamictree-folder_lastsub';
            
          }
            
            this.element.addClass("dynamictree").css("float",this.floatt);
        }
          
          
          
          
          
     }
     
     
     Setuptree.prototype.generate=function(){
        
                
               
                
                
                $.ajax({
                    type : "GET",
                    url : "parent_tree.php",
                    
                    headers : {
                            "X-REQUESTED-BY" : "Dynamic-Tree"
                    },
                    contentType : "application/json;charset=utf-8",
                    data : 'param='+JSON.stringify({tablename : $self.config.tablename,tablefields : $self.config.fields,startfrom : $self.config.startfrom}),
                   dataType : "json",
                    context : $self.element,
                    beforeSend : function(){
                       //$(this).html("Loading..");
                    }
                    
                    
                }).done(function(data){
                   //success
                        //$(this).html('');
                        
                        $(this).css('direction',$self.direction); // direction
                        
                       var $ul=$("<ul/>").appendTo($self.element);
                       
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
                                  }).appendTo($ul);
                                
                             $("<div/>",{
                                "class" : $self.imageclass// css sprite image according to language
                                
                             }).css('float',$self.floatt).addClass($self.nodetype).appendTo($li);
                           
                              $('<a/>',{
                                href : "sub_node.php",
                                text : result[2][1]
                               // id    : result[0][1],
                                
                            
                                                        
                                }).appendTo($li);
                             
                           
                         
                          
                        
                          
                          
                      });
                                                
                       
                         
                    
                }).fail(function(m){
                    
                    $(this).html("Sorry Something Went Wrong!");
                    
                });
       
       
     };  
     

       
    
     
       Setuptree.prototype.subTree=function(elem){
            
            
            
            var $ul=$("<ul/>").appendTo(elem);
            
            $("<li>").appendTo($ul);
            
                                $('<a/>',{
                                href : "sub_node.php",
                                 text : "subnode 2"
                               // id    : result[0][1],
                                
                            
                                                        
                                }).appendTo(elem);
                                               
            
            
        };
         
        
        $.fn.dynamictree=function(options){
            
            var element=this;            
            new Setuptree(element,options)
            
        
        };
        
        
    
})(jQuery);