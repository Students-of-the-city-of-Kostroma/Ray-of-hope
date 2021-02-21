package com.example.splashapp;


import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;


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
        new Network().RegOrg(input);


        if(input[4].equals(input[3])) {
/*
            try {

                boolean errors = Ret.contains("name");
                if (errors == true) {
                    Toast toast = Toast.makeText(RegOrg.this, "Неккоректное название", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.RIGHT, 0, -150);
                    toast.show();
                    Error = true;
                }
                errors = Ret.contains("INN");
                if (errors == true) {
                    Toast toast = Toast.makeText(RegOrg.this, "Некорректный ИНН", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.RIGHT, 0, -70);
                    toast.show();
                    Error = true;
                }
                errors = Ret.contains("email");
                if (errors == true) {
                    Toast toast = Toast.makeText(RegOrg.this, "Неправильный E-mail", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.RIGHT, 0, -0);
                    toast.show();
                    Error = true;
                }

                errors = Ret.contains("password");
                if (errors == true) {
                    Toast toast = Toast.makeText(RegOrg.this, "Минимум 6 знаков:\\nцифры и латинские\\nбуквы\"", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.RIGHT, 0, 70);
                    toast.show();
                    Error = true;
                }
                errors = Ret.contains("empty");
                if (errors == true) {
                    Toast toast = Toast.makeText(RegOrg.this, "Заполните все поля", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.CENTER, 0, 100);
                    toast.show();
                    Error = true;
                }

                if (Error == false) {
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

            } catch (InterruptedException e) {
                e.printStackTrace();
            } catch (ExecutionException e) {
                e.printStackTrace();
            } catch (TimeoutException e) {
                e.printStackTrace();
            } */
        }
        else
        {
            Toast toast = Toast.makeText(RegOrg.this, "Пароли не совпадают", Toast.LENGTH_LONG);
            toast.setGravity(Gravity.RIGHT, 0, 70);
            toast.show();
        }

    }
}
