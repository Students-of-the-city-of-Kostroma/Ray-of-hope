package com.example.splashapp;

import java.util.ArrayList;
import java.util.List;

public class C_Citizen extends ControllerUser{


    List<M_Citizen> ListCitizen=new ArrayList<M_Citizen>();
    public C_Citizen() { }

    @Override
    public M_Citizen Update(M_User Citizen) { return null; }
    @Override
    public  M_Citizen Autorization(M_User Citizen){ return null; }

    @Override
    public  M_Citizen Registration(M_User Citizen){ return null; }

    @Override
    public  M_User getDateProfile (){ return null; }
}
