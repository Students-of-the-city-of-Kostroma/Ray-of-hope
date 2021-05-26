package com.example.splashapp;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

public class C_Activitisms extends ControllerPost{

    static public List<M_Activism> ListActivism=new ArrayList<M_Activism>();
    static Date d=new Date(2020,6,10);
    public C_Activitisms() { }
    static public void C_Act() {
        ListActivism.add(new M_Activism("0","Название","блаблаблаблаблаблаблаблаблаба","Какая-то организация"));
        ListActivism.add(new M_Activism("1","Абвг","блаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблаба","Какая-то организация 2"));
    }

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
    public  M_Activism DeleteComment(M_Post Activitisms, M_Comment comment) { return null; }

    @Override
    public  M_Activism RefreshList(M_Post Activitisms, M_Comment comment){ return null; }
} 

