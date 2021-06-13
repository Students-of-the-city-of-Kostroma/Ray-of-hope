package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import com.example.splashapp.Dialogs.OkDialog;
import org.json.JSONObject;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;

public class LoginOrgActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_org);
    }
    public static String MyOrgId;

    public void LoginOrg(View view)
    {
        String[] input=new String[2];
        boolean Error = false;

        EditText edit = (EditText)findViewById(R.id.etemail);
        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.editText13);
        input[1] = edit.getText().toString();

        C_Organization.MyOrg=new Network().LoginOrg(input);
        if (C_Organization.MyOrg!=null) {
            Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);
            finish();
        }
        else {
            OkDialog okDialog = new OkDialog();
            okDialog.setMess("Неверные логин/пароль");
            okDialog.show(getFragmentManager(), "okDialog");
        }
        /*
        try {

            boolean errors = Ret.contains("not_found_org");
            if (errors == true) {

                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Пользователь не найден");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("empty");
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Заполните все поля");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("password_error"); //Не работает, т.к. нет на php
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess("Неверный пароль");
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            errors = Ret.contains("Error");
            if (errors == true) {
                OkDialog okDialog = new OkDialog();
                okDialog.setMess(Ret);
                okDialog.show(getFragmentManager(), "okDialog");
                Error = true;
            }

            if (Error == false) {

                Intent intent = new Intent(this, MyOrgProf.class);
                JSONObject json = new JSONObject(Ret);
                MyOrgId=json.get("id").toString();
                startActivity(intent);
                finish();
            }

        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (TimeoutException e) {
            e.printStackTrace();
        } catch (Exception e) {
            e.printStackTrace();
        } */

    }


    public void OrgRegisrt(View view)
    {
        Intent intent = new Intent(this, RegOrg.class);
        startActivity(intent);
        finish();
    }
}
