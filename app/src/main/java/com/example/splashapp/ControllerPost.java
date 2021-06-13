package com.example.splashapp;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class ControllerPost {

    static public List<M_Post> ListActivism=new ArrayList<M_Post>();
    static Date d=new Date(2020,6,10);
    public ControllerPost() { }
    static public void C_Act() {
        ListActivism.add(new M_Post("0","Название","блаблаблаблаблаблаблаблаблаба","Какая-то организация"));
        ListActivism.add(new M_Post("1","Абвг","блаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблабаблаблаблаблаблаблаблаблаблаба","Какая-то организация 2"));
    }


    public M_Post Add(M_Post Activitisms) {
        return null;
    }


    public M_Post Update(M_Post Activitisms) {
        return null;
    }


    public M_Post Delete(M_Post Activitisms) { return null; }


    public  M_Post AddComment(M_Post Activitisms, M_Comment comment) { return null; }


    public  M_Post DeleteComment(M_Post Activitisms, M_Comment comment) { return null; }


    public  M_Post RefreshList(M_Post Activitisms, M_Comment comment){ return null; }

}
