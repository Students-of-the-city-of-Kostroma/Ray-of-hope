package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Activitisms extends ControllerPost{

    List<M_Activism> ListActivism=new ArrayList<M_Activism>();
    public C_Activitisms() { }

    @Override
    public M_Activism Add(M_Post Activitisms) {
        return null;
    }

    @Override
    public M_Activism Update(M_Post Activitisms) {
        return null;
    }

    @Override
    public M_Activism Delete(M_Post Activitisms) { return null; }

    @Override
    public  M_Activism AddComment(M_Post Activitisms, M_Comment comment) { return null; }

    @Override
    public  M_Activism RefreshList(M_Post Activitisms, M_Comment comment){ return null; }
} 

