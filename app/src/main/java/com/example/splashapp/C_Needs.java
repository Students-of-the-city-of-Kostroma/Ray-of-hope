package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Needs extends ControllerPost{

    List<M_Need> ListNeed=new ArrayList<M_Need>();
    public C_Needs() { }

    @Override
    public M_Need Add(M_Post Needs) { return null; }

    @Override
    public M_Need Update(M_Post Needs) { return null; }

    @Override
    public M_Need Delete(M_Post Needs) {
        return null;
    }

    @Override
    public  M_Need AddComment(M_Post Needs, M_Comment comment) { return null; }

    @Override
    public  M_Need DeleteComment(M_Post Needs, M_Comment comment) { return null; }

    @Override
    public  M_Need RefreshList(M_Post Needs, M_Comment comment){ return null; }
}
