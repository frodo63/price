function fastPrice(tick,lzak,ltzr,ltp,ltpr,wt,lop,firstoh){};
    //Расчет цены
    var la = (lzak + ltzr);
    var lwt = la*0.0125*wt;
    var lnam = (la+lwt)*lop/100;
    var lim = (la+lwt+lnam)*ltp/100;

    var lprice = la + lwt + lim + lnam;

    lop = 100/(100+ltp) * (lprice*100/(lzak+ltzr+lwt) - 100 - ltp);



    lop = 100/(100+ltp) * (lprice*100/(lzak+ltzr+lwt) - 100 - ltp);
    lop = 100/(100+ltp) * ((lnam*100/lrentS)*100/(lzak+ltzr+lwt) - 100 - ltp);

    //Как имея цену и наценку получить