const tc = TouchController();
tc.touchBase.on('touchMove',function(msg){
    console.log(msg);
});