package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Events extends ControllerPost{

    static public  List<M_Event> ListEvent=new ArrayList<M_Event>();

    public C_Events() { }
    static public void C_Ev() {
        //ListEvent.add(new M_Event("0","Абвг","блаблаблаблаблаблаблаблаблаба","2020-06-10","2020-06-08","йцу"));
    }

    @Override
    public M_Event Add(M_Post Events) {
        return null;
    }

    @Override
    public M_Event Update(M_Post Events) { return null; }

    @Override
    public M_Event Delete(M_Post Events) {
        return null;
    }

    @Override
    public  M_Event AddComment(M_Post Events, M_Comment comment) { return null; }

    @Override
    public  M_Event DeleteComment(M_Post Events, M_Comment comment) { return null; }

    @Override
    public  M_Event RefreshList(M_Post Events, M_Comment comment){ return null; }
}
