package com.example.splashapp;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import java.util.concurrent.ExecutionException;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;

public class LoginOrgActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_org);
    }
    public static String MyEmail;

    public void LoginOrg(View view)
    {
        String[] input=new String[2];
        boolean Error = false;

        EditText edit = (EditText)findViewById(R.id.editText10);
        input[0] = edit.getText().toString();

        edit = (EditText)findViewById(R.id.editText13);
        input[1] = edit.getText().toString();

        CallDB_LoginOrg RO=new CallDB_LoginOrg();
        RO.execute(input);
        String Ret = "";

        try {
            Ret = RO.get(5, TimeUnit.SECONDS);

            boolean errors = Ret.contains("not_found_org");
            if (errors == true) {

                AlertDialog.Builder builder = new AlertDialog.Builder(LoginOrgActivity.this, R.style.AlertDialogCustom);
                builder.setMessage("Пользователь не найден")
                        .setTitle("Ошибка")
                        .setCancelable(false)
                        .setPositiveButton("ОК",
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        dialog.cancel();

                                    }
                                });
                AlertDialog alert = builder.create();
                alert.show();

                Error = true;
            }

            errors = Ret.contains("empty");
            if (errors == true) {
                AlertDialog.Builder builder = new AlertDialog.Builder(LoginOrgActivity.this, R.style.AlertDialogCustom);
                builder.setMessage("Заполните все поля")
                        .setTitle("Ошибка")
                        .setCancelable(false)
                        .setPositiveButton("ОК",
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        dialog.cancel();

                                    }
                                });
                AlertDialog alert = builder.create();
                alert.show();

                Error = true;
            }

            errors = Ret.contains("password"); //Не работает, на будущее
            if (errors == true) {
                AlertDialog.Builder builder = new AlertDialog.Builder(LoginOrgActivity.this, R.style.AlertDialogCustom);
                builder.setMessage("Неверный пароль")
                        .setTitle("Ошибка")
                        .setCancelable(false)
                        .setPositiveButton("ОК",
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        dialog.cancel();
                                    }
                                });
                AlertDialog alert = builder.create();
                alert.show();

                Error = true;
            }

            if (Error == false) {

                Intent intent = new Intent(this, MyOrgProf.class);
                MyEmail=input[0];
                startActivity(intent);
                finish();
            }

        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (TimeoutException e) {
            e.printStackTrace();
        }

    }


    public void OrgRegisrt(View view)
    {
        Intent intent = new Intent(this, RegOrg.class);
        startActivity(intent);
        finish();
    }
}
