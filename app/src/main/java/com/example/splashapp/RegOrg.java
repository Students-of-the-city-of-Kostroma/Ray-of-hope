package com.example.splashapp;


import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.example.splashapp.Dialogs.OkDialog;


public class RegOrg extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reg_org);
    }

    public void EnterToOrg(View view)
    {
        Intent intent = new Intent(this, LoginOrgActivity.class);
        startActivity(intent);
        finish();
    }

    public  void Registr(View view)
    {


        String[] input=new String[5];
        EditText edit = (EditText)findViewById(R.id.editText6);
        boolean Error = false;

        EditText edit1=(EditText)findViewById(R.id.editText11);
        input[4] = edit1.getText().toString();

        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.editText7);
        input[1] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.editText8);
        input[2] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.editText9);
        input[3] = edit.getText().toString();


        if(!input[4].equals(input[3]))
        {
            Toast toast = Toast.makeText(RegOrg.this, "Пароли не совпадают", Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, 70);
            toast.show();
        }


        if (!Error) {

            boolean mc= new Network().RegOrg(input);

            if (mc)
            {
                AlertDialog.Builder adb = new AlertDialog.Builder(this);
                adb.setTitle("Успех");
                adb.setMessage("Регистрация прошла успешно");
                adb.setNegativeButton("ОК", new DialogInterface.OnClickListener(){
                    @Override
                    public void onClick(DialogInterface d, int arg1) {
                        GoBack();
                    };
                });
                adb.show();
            }
            else {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Не удалось зарегистрироваться");
                okDialog.show(getFragmentManager(), "okDialog");
            }
        }
    }
    public  void GoBack()
    {
        Intent intent = new Intent(this, LoginCitizenActivity.class);
        startActivity(intent);
        finish();
    }
}
