package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Events extends ControllerPost{

    List<M_Event> ListEvent=new ArrayList<M_Event>();
    public C_Events() { }

    @Override
    public boolean Add(M_Post Events) {
        return true;
    }

    @Override
    public boolean Update(M_Post Events) { return true; }

    @Override
    public boolean Delete(M_Post Events) {
        return true;
    }

    @Override
    public  boolean AddComment(M_Post Events, M_Comment comment) { return true; }

    @Override
    public  boolean DeleteComment(M_Post Events, M_Comment comment) { return true; }

    @Override
    public  boolean RefreshList(M_Post Events, M_Comment comment){ return true; }
}
