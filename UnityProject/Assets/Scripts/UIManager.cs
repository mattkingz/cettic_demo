using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class UIManager : MonoBehaviour {

    private static UIManager instance;
    public static UIManager Instance
    {
        get
        {
            if (!instance) instance = GameObject.FindObjectOfType<UIManager>();
            return instance;
        }
    }

    [Header("Gameplay")]
    public GameObject panelGameplay;
    public Text lblScore, lblTime;

    [Header("GameOver")]
    public GameObject panelGameOver;
    public Text lblGameOverTitle, lblGameOverScore;

    [Header("Login")]
    public GameObject panelLogin;
    public InputField txtLoginUsername, txtLoginPassword;

    [Header("Register")]
    public GameObject panelRegister;
    public InputField txtSignupUsername, txtSignupPassword1, txtSignupPassword2;

    [Header("Loading Screen")]
    public GameObject panelLoading;

    [Header("Error Screen")]
    public GameObject panelError;
    public Text lblError;

    public void SetScore(float score)
    {
        lblScore.text = "Score: " + score;
    }

    public void SetTime(float time)
    {
        lblTime.text = "Tiempo: " + Mathf.CeilToInt(time);
    }

    public void ShowGameOver(float score, string title = "Game Over")
    {
        ShowPanel(panelGameOver);
        lblGameOverTitle.text = title;
        lblGameOverScore.text = "Score: " + score;
    }

    //Funcion de ayuda para mostrar una ventana desactivando el resto (del menu)
    public void ShowPanel(GameObject panel)
    {
        panelGameOver.SetActive(panel == panelGameOver);
        panelGameplay.SetActive(panel == panelGameplay);
        panelLogin.SetActive(panel == panelLogin);
        panelRegister.SetActive(panel == panelRegister);
    }

    //Se muestra la pantalla de carga
    public void NowLoading()
    {
        panelLoading.SetActive(true);
    }

    //Se oculta la pantalla de carga
    public void FinishLoading()
    {
        panelLoading.SetActive(false);
    }

    //Mensaje de error que desaparece al hacer click
    public void ShowError(string msg = "Error")
    {
        panelError.SetActive(true);
        lblError.text = msg;
    }

    public void SignUp()
    {
        DatabaseConnection.Instance.SignUp(txtSignupUsername.text, txtSignupPassword1.text, txtSignupPassword2.text);
    }

    public void ClickLogin()
    {
        DatabaseConnection.Instance.Login(txtLoginUsername.text, txtLoginPassword.text);
    }

}
