package com.example.splashapp;


import org.junit.Test;

import static org.junit.Assert.*;

public class UT_Citizen {
    @Test
    public void Task_12_1()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        int x=1;
        assertEquals(x,Cit.getId());

    }
    @Test
    public void Task_12_2()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="lala@mail.ru";
        assertEquals(x,Cit.getEmail());

    }
    @Test
    public void Task_12_3()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x=" ";
        assertEquals(x,Cit.getAbout());

    }
    @Test
    public void Task_12_4()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="ava.png";
        assertEquals(x,Cit.getImageName());

    }
    @Test
    public void Task_12_5()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="1234567";
        assertEquals(x, Cit.getNumber());

    }
    @Test
    public void Task_12_6()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="Иван";
        assertEquals(x, Cit.getFirstName());

    }
    @Test
    public void Task_12_7()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="Иванов";
        assertEquals(x, Cit.getLastName());

    }
    @Test
    public void Task_12_8()

            throws Exception
    {
        Citizen Cit=new Citizen(1, "lala@mail.ru", " ", "ava.png", "1234567", "Иван","Иванов", "Кострома")  ;
        String x="Кострома";
        assertEquals(x, Cit.getCity());

    }

}
