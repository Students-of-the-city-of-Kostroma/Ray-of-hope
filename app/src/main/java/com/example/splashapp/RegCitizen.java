package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import com.example.splashapp.Dialogs.OkDialog;

public class RegCitizen extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reg_citizen);
    }

    public void EnterToCitizen(View view)
    {
        Intent intent = new Intent(this, LoginCitizenActivity.class);
        startActivity(intent);
        finish();
    }
    public void Registr(View view)
    {String[] input=new String[6];
        boolean Error = false;

        EditText edit = (EditText)findViewById(R.id.edtname);
        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etfam);
        input[1] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.edtoname);
        input[2] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etemail);
        input[3] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etpas);
        input[4] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.etpas2);
        input[5] = edit.getText().toString();


        if (input[0].isEmpty()||input[1].isEmpty()||input[2].isEmpty()||input[3].isEmpty()) {
            OkDialog okDialog = new OkDialog();
            okDialog.setMess("Заполните все поля");
            okDialog.show(getFragmentManager(), "okDialog");
            Error=true;
        }

        if (input[4].length()<7&&!Error) {
            OkDialog okDialog = new OkDialog();
            okDialog.setMess("Пароль должен быть длиннее 6 символов");
            okDialog.show(getFragmentManager(), "okDialog");
            Error=true;
        }

        if (!input[3].contains("@")&&!Error) {
            OkDialog okDialog = new OkDialog();
            okDialog.setMess("Неверный формат E-mail");
            okDialog.show(getFragmentManager(), "okDialog");
            Error=true;
        }


        if (!Error) {

            M_Citizen mc= new Network().RegCit(input);

            if (mc!=null)
            {
                OkDialog okDialog = new OkDialog();
                okDialog.setHead("Успех");
                okDialog.setMess("Регистрация прошла успешно");
                okDialog.show(getFragmentManager(), "okDialog");

            Intent intent = new Intent(this, LoginCitizenActivity.class);
            startActivity(intent);
            finish();
            }
            else {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Не удалось зарегистрироваться");
                okDialog.show(getFragmentManager(), "okDialog");
            }
        }
    }
}
