package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Events extends ControllerPost{

    List<M_Event> ListEvent=new ArrayList<M_Event>();
    public C_Events() { }

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
    public  M_Event RefreshList(M_Post Events, M_Comment comment){ return null; }
}
