AUI.add("aui-viewport",function(k){var c=k.Lang,g=k.getClassName,i=YUI.AUI.namespace("defaults.viewport"),e="view",r=g(e)+k.config.classNameDelimiter,p=i.columns||(i.columns={12:960,9:720,6:480,4:320}),m=i.minColumns||(i.minColumns=4),q=k.config.doc.documentElement,f=k.getWin(),n=new RegExp("(\\s|\\b)+"+r+"(lt|gt)*\\d+(\\b|\\s)+","g"),j=" ",l="",b="gt",o="lt";var a=function(t){var v=[];var x=q.className.replace(n,l);var s=x;var y=q.clientWidth;var A=m;var z;var u;for(var w in p){u=p[w];if(y>=u){z=b;A=Math.max(A,u);}else{z=o;}v.push(r+z+u);}v.push(r+A);s+=j+v.join(j);if(x!=s){q.className=s;}};var d=f.on("resize",k.debounce(a,50));var h=f.on("orientationchange",a);a();k.Viewport={viewportChange:a,_orientationHandle:h,_resizeHandle:d};},"@VERSION@",{requires:["aui-base"],skinnable:false});