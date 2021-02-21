package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Citizen extends ControllerUser{


    static List<M_Citizen> ListCitizen=new ArrayList<M_Citizen>();
    public static M_Citizen Iam;
    //static  M_Citizen mecit=new M_Citizen("1","q@cd.com","блаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблаблабла", "","1234567890","Иван","Иванович","Кострома");
    public C_Citizen() {
        //ListCitizen.add(mecit);
    }
    static public void C_Cit() {
        //ListCitizen.add(mecit);
    }
    @Override
    public M_Citizen Update(M_User Citizen) { return null; }
    @Override
    public  M_Citizen Autorization(M_User Citizen){ return null; }

    @Override
    public  M_Citizen Registration(M_User Citizen){ return null; }

    @Override
    public  M_User getDateProfile (){ return null; }

    public void  RefreshList(List<M_Citizen> ListChat) {}
}
