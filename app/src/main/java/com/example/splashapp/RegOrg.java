package com.example.splashapp;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import java.util.regex.Pattern;
import java.util.regex.Matcher;


public class RegOrg extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reg_org);
    }

    public void EnterToOrg(View view)
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
        finish();
    }

    public  void Registr(View view)
    {

        //почта
        String[] input=new String[4];
        EditText edit = (EditText)findViewById(R.id.editText6);
        boolean Error = false;


        input[0] = edit.getText().toString();
        boolean  result = input[0].matches("([a-zA-Z0-9а-яА-ЯёЁ,-].{1,100}$)");//название, 100 символов, можно использовать , и -
        if(result==false){
            Toast toast = Toast.makeText(RegOrg.this, "Неккоректное название",Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, -150);
            toast.show();
            Error=true;
        }
        edit = (EditText)findViewById(R.id.editText7);
        input[1] = edit.getText().toString();
        result = input[1].matches("([0-9].{10,12}$)");//ИНН, 10 цифр для юрлиц, 12 цифр для физлиц и ИП
        if(result==false){
            Toast toast = Toast.makeText(RegOrg.this, "Некорректный ИНН",Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, -70);
            toast.show();
            Error=true;
        }
        edit = (EditText)findViewById(R.id.editText8);
        input[2] = edit.getText().toString();
        result = input[2].matches("([a-zA-Z0-9]+(?:[._+-][a-zA-Z0-9]+)*)@([a-zA-Z0-9]+(?:[.-][a-zA-Z0-9]+)*[.][a-zA-Z]{2,})");
        if(result==false){
            Toast toast = Toast.makeText(RegOrg.this, "Неправильный E-mail",Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, 00);
            toast.show();
            Error=true;
        }
        edit = (EditText)findViewById(R.id.editText9);
        input[3] = edit.getText().toString();
        result = input[3].matches("([a-zA-Z0-9].{6,}$)");//пароль
        if(result==false){
            Toast toast = Toast.makeText(RegOrg.this, "Минимум 6 знаков:\nцифры и латинские\nбуквы",Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, 70);
            toast.show();
            Error=true;
        }
            if (!Error)
            {
                AlertDialog.Builder builder = new AlertDialog.Builder(RegOrg.this, R.style.AlertDialogCustom);
                builder.setMessage("На указанную почту отправленно письмо для подтверждения")
                        .setTitle("Подтверждение почты")
                        .setCancelable(false)
                        .setPositiveButton("ОК",
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        dialog.cancel();
                                    }
                                });
                AlertDialog alert = builder.create();
                alert.show();
            }
    }
}
